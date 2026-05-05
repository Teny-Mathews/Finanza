<?php
include("../Assets/Connection/Connection.php");
session_start();

// Check if user is logged in
if(!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['uid'];

// Process filter form submission
$view_mode = isset($_POST['view_mode']) ? $_POST['view_mode'] : 'expense'; // expense or savings
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-01'); // First day of current month
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-t'); // Last day of current month

// Build query based on filters
$query_conditions = "WHERE e.user_id = $user_id AND expense_date BETWEEN '$start_date' AND '$end_date'";

// Get expense data
$expense_data = array();
$expense_query = "SELECT * FROM tbl_expense e 
                  INNER JOIN tbl_expensetype et ON et.expensetype_id = e.expensetype_id 
                  $query_conditions 
                  ORDER BY expense_date";
$expense_result = $con->query($expense_query);

if($expense_result && $expense_result->num_rows > 0) {
    while($row = $expense_result->fetch_assoc()) {
        $expense_data[] = $row;
    }
}

// Calculate total expenses and group by category
$total_expenses = 0;
$expenses_by_category = array();
$expenses_by_date = array();

foreach($expense_data as $expense) {
    $total_expenses += $expense['expense_price'];
    
    // Group by category
    $category_name = $expense['expensetype_name'];
    if(!isset($expenses_by_category[$category_name])) {
        $expenses_by_category[$category_name] = 0;
    }
    $expenses_by_category[$category_name] += $expense['expense_price'];
    
    // Group by date for bar chart
    $date = date('M j', strtotime($expense['expense_date']));
    if(!isset($expenses_by_date[$date])) {
        $expenses_by_date[$date] = 0;
    }
    $expenses_by_date[$date] += $expense['expense_price'];
}

// Calculate savings data
$total_income = 50000; // Example fixed income - you can replace this with actual income data
$total_savings = $total_income - $total_expenses;
$savings_rate = $total_income > 0 ? ($total_savings / $total_income) * 100 : 0;

// Prepare data for charts based on view mode
if($view_mode == 'expense') {
    // Expense view data
    $chart_title = 'Expenses by Category';
    $bar_chart_title = 'Daily Expenses Trend';
    $chart_labels = array_keys($expenses_by_category);
    $chart_values = array_values($expenses_by_category);
    $bar_labels = array_keys($expenses_by_date);
    $bar_values = array_values($expenses_by_date);
} else {
    // Savings view data
    $chart_title = 'Income Distribution';
    $bar_chart_title = 'Savings Trend';
    $chart_labels = ['Expenses', 'Savings'];
    $chart_values = [$total_expenses, $total_savings];
    
    // Calculate savings trend (cumulative savings over time)
    $savings_by_date = array();
    if(count($expenses_by_date) > 0) {
        $daily_income = $total_income / count($expenses_by_date);
        $cumulative_savings = 0;
        
        foreach($expenses_by_date as $date => $expense) {
            $cumulative_savings += ($daily_income - $expense);
            $savings_by_date[$date] = $cumulative_savings;
        }
    }
    $bar_labels = array_keys($savings_by_date);
    $bar_values = array_values($savings_by_date);
}

// Generate colors for charts
$colors = generateColors(count($chart_labels));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Analysis</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            align-items: center;
        }
        .filters select, .filters input, .filters button {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .filters button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .filters button:hover {
            background-color: #45a049;
        }
        .summary-cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .card {
            flex: 1;
            min-width: 200px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .expense-card {
            background-color: #ffebee;
            border-left: 4px solid #f44336;
        }
        .savings-card {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
        }
        .income-card {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
        }
        .card h3 {
            margin-top: 0;
            color: #555;
        }
        .card .amount {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .expense-amount {
            color: #f44336;
        }
        .savings-amount {
            color: #4caf50;
        }
        .income-amount {
            color: #2196f3;
        }
        .charts-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .chart-box {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            height: 400px;
        }
        .chart-box h3 {
            text-align: center;
            margin-top: 0;
            color: #555;
            margin-bottom: 15px;
        }
        .chart-container {
            height: 350px;
            position: relative;
        }
        .expense-list {
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        .savings-info {
            background-color: #e8f5e9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .charts-container {
                grid-template-columns: 1fr;
            }
            .summary-cards {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Budget Analysis</h1>
        
        <!-- Filters -->
        <form method="POST" action="" id="filterForm">
            <div class="filters">
                <select name="view_mode" onchange="document.getElementById('filterForm').submit()">
                    <option value="expense" <?php echo $view_mode == 'expense' ? 'selected' : ''; ?>>Expense View</option>
                    <option value="savings" <?php echo $view_mode == 'savings' ? 'selected' : ''; ?>>Savings View</option>
                </select>
                
                <input type="date" name="start_date" value="<?php echo $start_date; ?>">
                <input type="date" name="end_date" value="<?php echo $end_date; ?>">
                
                <button type="submit">Apply Filters</button>
            </div>
        </form>
        
        <!-- Summary Cards -->
        <div class="summary-cards">
            <?php if($view_mode == 'expense'): ?>
                <div class="card expense-card">
                    <h3>Total Expenses</h3>
                    <div class="amount expense-amount">₹<?php echo number_format($total_expenses); ?></div>
                    <p>Between <?php echo date('M j, Y', strtotime($start_date)); ?> and <?php echo date('M j, Y', strtotime($end_date)); ?></p>
                </div>
            <?php else: ?>
                <div class="card savings-card">
                    <h3>Total Savings</h3>
                    <div class="amount savings-amount">₹<?php echo number_format($total_savings); ?></div>
                    <p>Between <?php echo date('M j, Y', strtotime($start_date)); ?> and <?php echo date('M j, Y', strtotime($end_date)); ?></p>
                </div>
                
                <div class="card income-card">
                    <h3>Total Income</h3>
                    <div class="amount income-amount">₹<?php echo number_format($total_income); ?></div>
                    <p>Projected monthly income</p>
                </div>
                
                <div class="card expense-card">
                    <h3>Total Expenses</h3>
                    <div class="amount expense-amount">₹<?php echo number_format($total_expenses); ?></div>
                    <p>Between <?php echo date('M j, Y', strtotime($start_date)); ?> and <?php echo date('M j, Y', strtotime($end_date)); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Additional Info for Savings View -->
        <?php if($view_mode == 'savings'): ?>
            <div class="savings-info">
                <h3>Savings Analysis</h3>
                <p>Your savings rate is <strong><?php echo number_format($savings_rate, 2); ?>%</strong> of your income.</p>
                <p>This means you're saving <strong>₹<?php echo number_format($total_savings / max(1, count($expenses_by_date)), 2); ?> per day</strong> on average.</p>
            </div>
        <?php endif; ?>

        <!-- Charts Container -->
        <?php if(count($expense_data) > 0 || $view_mode == 'savings'): ?>
        <div class="charts-container">
            <!-- Pie Chart -->
            <div class="chart-box">
                <h3><?php echo $chart_title; ?></h3>
                <div class="chart-container">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
            
            <!-- Bar Graph -->
            <div class="chart-box">
                <h3><?php echo $bar_chart_title; ?></h3>
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Expense List (only shown in expense view) -->
        <?php if($view_mode == 'expense'): ?>
            <div class="expense-list">
                <h3>Expense Details</h3>
                <?php if(count($expense_data) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Payment Mode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($expense_data as $expense): ?>
                                <tr>
                                    <td><?php echo date('M j, Y', strtotime($expense['expense_date'])); ?></td>
                                    <td><?php echo htmlspecialchars($expense['expense_title']); ?></td>
                                    <td><?php echo htmlspecialchars($expense['expensetype_name']); ?></td>
                                    <td>₹<?php echo number_format($expense['expense_price']); ?></td>
                                    <td><?php echo htmlspecialchars($expense['expense_mode']); ?></td>
                                    <td><?php echo $expense['expense_status'] == 1 ? 'Approved' : 'Pending'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">
                        <p>No expenses found for the selected period.</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        <?php if(count($expense_data) > 0 || $view_mode == 'savings'): ?>
        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($chart_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($chart_values); ?>,
                    backgroundColor: <?php echo json_encode($colors); ?>,
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ₹${value.toLocaleString()} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($bar_labels); ?>,
                datasets: [{
                    label: '<?php echo $view_mode == 'expense' ? 'Daily Expenses' : 'Cumulative Savings'; ?>',
                    data: <?php echo json_encode($bar_values); ?>,
                    backgroundColor: '<?php echo $view_mode == 'expense' ? 'rgba(54, 162, 235, 0.7)' : 'rgba(75, 192, 192, 0.7)'; ?>',
                    borderColor: '<?php echo $view_mode == 'expense' ? 'rgba(54, 162, 235, 1)' : 'rgba(75, 192, 192, 1)'; ?>',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (₹)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '₹' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Amount: ₹${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                }
            }
        });
        <?php endif; ?>
    </script>
</body>
</html>

<?php
// Function to generate distinct colors for pie chart
function generateColors($count) {
    $colors = [];
    $baseColors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
        '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF',
        '#4DC9F6', '#F67019', '#F53794', '#537BC4',
        '#ACC236', '#166A8F', '#00A950', '#58595B'
    ];
    
    for($i = 0; $i < $count; $i++) {
        $colors[] = $baseColors[$i % count($baseColors)];
    }
    
    return $colors;
}
?>