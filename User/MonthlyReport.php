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
$selected_year = isset($_POST['year']) ? $_POST['year'] : date('Y');
$selected_month = isset($_POST['month']) ? $_POST['month'] : date('m');

// Get available years from database
$years_query = "SELECT DISTINCT YEAR(expense_date) as year FROM tbl_expense WHERE user_id = $user_id 
                UNION 
                SELECT DISTINCT YEAR(income_date) as year FROM tbl_income WHERE user_id = $user_id 
                ORDER BY year DESC";
$years_result = $con->query($years_query);
$available_years = array();
if($years_result && $years_result->num_rows > 0) {
    while($row = $years_result->fetch_assoc()) {
        $available_years[] = $row['year'];
    }
}
if(empty($available_years)) {
    $available_years = [date('Y')];
}

// Months array
$months = array(
    '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
    '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
    '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
);

// Calculate date range for selected month
$start_date = "$selected_year-$selected_month-01";
$end_date = date('Y-m-t', strtotime($start_date));

// Get expense data for the selected month
$expense_data = array();
$expense_query = "SELECT * FROM tbl_expense e 
                  INNER JOIN tbl_expensetype et ON et.expensetype_id = e.expensetype_id 
                  WHERE e.user_id = $user_id 
                  AND expense_date BETWEEN '$start_date' AND '$end_date'
                  ORDER BY expense_date";
$expense_result = $con->query($expense_query);

if($expense_result && $expense_result->num_rows > 0) {
    while($row = $expense_result->fetch_assoc()) {
        $expense_data[] = $row;
    }
}

// Get income data for the selected month
$income_data = array();
$income_query = "SELECT * FROM tbl_income i 
                 INNER JOIN tbl_incometype it ON it.incometype_id = i.incometype_id 
                 WHERE i.user_id = $user_id 
                 AND income_date BETWEEN '$start_date' AND '$end_date'
                 ORDER BY income_date";
$income_result = $con->query($income_query);

if($income_result && $income_result->num_rows > 0) {
    while($row = $income_result->fetch_assoc()) {
        $income_data[] = $row;
    }
}

// Calculate totals
$total_expenses = 0;
$total_income = 0;
$net_savings = 0;

// Calculate expense totals by category and date
$expenses_by_category = array();
$daily_expenses = array();
$expense_dates = array();

for($day = 1; $day <= date('t', strtotime($start_date)); $day++) {
    $date = sprintf("%s-%02d", $selected_year . '-' . $selected_month, $day);
    $daily_expenses[$date] = 0;
    $expense_dates[] = $date;
}

foreach($expense_data as $expense) {
    $total_expenses += $expense['expense_price'];
    
    // Group by category
    $category_name = $expense['expensetype_name'];
    if(!isset($expenses_by_category[$category_name])) {
        $expenses_by_category[$category_name] = 0;
    }
    $expenses_by_category[$category_name] += $expense['expense_price'];
    
    // Group by date
    $date = $expense['expense_date'];
    if(isset($daily_expenses[$date])) {
        $daily_expenses[$date] += $expense['expense_price'];
    }
}

// Calculate income totals by category and date
$income_by_category = array();
$daily_income = array();
$income_dates = array();

for($day = 1; $day <= date('t', strtotime($start_date)); $day++) {
    $date = sprintf("%s-%02d", $selected_year . '-' . $selected_month, $day);
    $daily_income[$date] = 0;
    $income_dates[] = $date;
}

foreach($income_data as $income) {
    $total_income += $income['income_amount'];
    
    // Group by category
    $category_name = $income['incometype_name'];
    if(!isset($income_by_category[$category_name])) {
        $income_by_category[$category_name] = 0;
    }
    $income_by_category[$category_name] += $income['income_amount'];
    
    // Group by date
    $date = $income['income_date'];
    if(isset($daily_income[$date])) {
        $daily_income[$date] += $income['income_amount'];
    }
}

// Calculate net savings
$net_savings = $total_income - $total_expenses;
$savings_rate = $total_income > 0 ? ($net_savings / $total_income) * 100 : 0;

// Prepare data for charts
$expense_category_labels = array_keys($expenses_by_category);
$expense_category_values = array_values($expenses_by_category);
$income_category_labels = array_keys($income_by_category);
$income_category_values = array_values($income_by_category);

// Daily data for line chart
$daily_dates = array();
$daily_expense_values = array();
$daily_income_values = array();
$cumulative_savings = array();

$running_savings = 0;
for($day = 1; $day <= date('t', strtotime($start_date)); $day++) {
    $date = sprintf("%s-%02d", $selected_year . '-' . $selected_month, $day);
    $formatted_date = date('M j', strtotime($date));
    $daily_dates[] = $formatted_date;
    
    $day_expense = isset($daily_expenses[$date]) ? $daily_expenses[$date] : 0;
    $day_income = isset($daily_income[$date]) ? $daily_income[$date] : 0;
    
    $daily_expense_values[] = $day_expense;
    $daily_income_values[] = $day_income;
    
    $running_savings += ($day_income - $day_expense);
    $cumulative_savings[] = $running_savings;
}

$expense_colors = generateExpenseColors(count($expenses_by_category));
$income_colors = generateIncomeColors(count($income_by_category));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Financial Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1400px;
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
            justify-content: center;
        }
        .filters select, .filters button {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .filters button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .filters button:hover {
            background-color: #45a049;
        }
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .income-card {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
        }
        .expense-card {
            background-color: #ffebee;
            border-left: 4px solid #f44336;
        }
        .savings-card {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
        }
        .card h3 {
            margin-top: 0;
            color: #555;
            font-size: 18px;
        }
        .card .amount {
            font-size: 28px;
            font-weight: bold;
            margin: 15px 0;
        }
        .income-amount {
            color: #4caf50;
        }
        .expense-amount {
            color: #f44336;
        }
        .savings-amount {
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
            padding: 20px;
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
        .data-tables {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 30px;
        }
        .data-table {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .data-table h3 {
            margin-top: 0;
            color: #555;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        .savings-analysis {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }
        .savings-analysis h3 {
            margin-top: 0;
            font-size: 24px;
        }
        .savings-stats {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }
        @media (max-width: 768px) {
            .charts-container, .data-tables {
                grid-template-columns: 1fr;
            }
            .summary-cards {
                grid-template-columns: 1fr;
            }
        }
        .expense-card {
    background-color: #fff3e0;
    border-left: 4px solid #fb8c00;
}
.expense-amount {
    color: #fb8c00;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Monthly Financial Report - <?php echo $months[$selected_month] . ' ' . $selected_year; ?></h1>
        
        <!-- Filters -->
        <form method="POST" action="">
            <div class="filters">
                <select name="year">
                    <?php foreach($available_years as $year): ?>
                        <option value="<?php echo $year; ?>" <?php echo $selected_year == $year ? 'selected' : ''; ?>>
                            <?php echo $year; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <select name="month">
                    <?php foreach($months as $key => $name): ?>
                        <option value="<?php echo $key; ?>" <?php echo $selected_month == $key ? 'selected' : ''; ?>>
                            <?php echo $name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit">Generate Report</button>
            </div>
        </form>
        
        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="card income-card">
                <h3>Total Income</h3>
                <div class="amount income-amount">₹<?php echo number_format($total_income); ?></div>
                <p><?php echo $months[$selected_month] . ' ' . $selected_year; ?></p>
            </div>
            
            <div class="card expense-card">
                <h3>Total Expenses</h3>
                <div class="amount expense-amount">₹<?php echo number_format($total_expenses); ?></div>
                <p><?php echo $months[$selected_month] . ' ' . $selected_year; ?></p>
            </div>
            
            <div class="card savings-card">
                <h3>Net Savings</h3>
                <div class="amount savings-amount">₹<?php echo number_format($net_savings); ?></div>
                <p><?php echo $months[$selected_month] . ' ' . $selected_year; ?></p>
            </div>
        </div>

        <!-- Savings Analysis -->
        <div class="savings-analysis">
            <h3>Financial Health Analysis</h3>
            <div class="savings-stats">
                <div class="stat-item">
                    <div class="stat-value"><?php echo number_format($savings_rate, 1); ?>%</div>
                    <div class="stat-label">Savings Rate</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">₹<?php echo number_format($total_income > 0 ? $total_expenses / $total_income * 100 : 0, 1); ?>%</div>
                    <div class="stat-label">Expense Ratio</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">₹<?php echo number_format($net_savings / max(1, count($expense_data))); ?></div>
                    <div class="stat-label">Avg Daily Savings</div>
                </div>
            </div>
        </div>

        <!-- Charts Container -->
        <div class="charts-container">
            <!-- Income vs Expenses Bar Chart -->
            <div class="chart-box">
                <h3>Income vs Expenses (Daily)</h3>
                <div class="chart-container">
                    <canvas id="comparisonChart"></canvas>
                </div>
            </div>
            
            <!-- Savings Trend Line Chart -->
            <div class="chart-box">
                <h3>Savings Trend</h3>
                <div class="chart-container">
                    <canvas id="savingsChart"></canvas>
                </div>
            </div>
            
            <!-- Expense Categories Pie Chart -->
            <div class="chart-box">
                <h3>Expense Categories</h3>
                <div class="chart-container">
                    <canvas id="expensePieChart"></canvas>
                </div>
            </div>
            
            <!-- Income Categories Pie Chart -->
            <div class="chart-box">
                <h3>Income Sources</h3>
                <div class="chart-container">
                    <canvas id="incomePieChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Data Tables -->
        <div class="data-tables">
            <!-- Income Table -->
            <div class="data-table">
                <h3>Income Details</h3>
                <?php if(count($income_data) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Source</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($income_data as $income): ?>
                                <tr>
                                    <td><?php echo date('M j, Y', strtotime($income['income_date'])); ?></td>
                                    <td><?php echo htmlspecialchars($income['income_title']); ?></td>
                                    <td><?php echo htmlspecialchars($income['incometype_name']); ?></td>
                                    <td>₹<?php echo number_format($income['income_amount']); ?></td>
                                    <td><?php echo htmlspecialchars($income['income_status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">No income data found for <?php echo $months[$selected_month] . ' ' . $selected_year; ?></div>
                <?php endif; ?>
            </div>

            <!-- Expense Table -->
            <div class="data-table">
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
                    <div class="no-data">No expense data found for <?php echo $months[$selected_month] . ' ' . $selected_year; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Income vs Expenses Bar Chart
        const comparisonCtx = document.getElementById('comparisonChart').getContext('2d');
        const comparisonChart = new Chart(comparisonCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($daily_dates); ?>,
                datasets: [
                    {
                        label: 'Income',
                        data: <?php echo json_encode($daily_income_values); ?>,
                        backgroundColor: 'rgba(76, 175, 80, 0.7)',
                        borderColor: 'rgba(76, 175, 80, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Expenses',
                        data: <?php echo json_encode($daily_expense_values); ?>,
                        backgroundColor: 'rgba(244, 67, 54, 0.7)',
                        borderColor: 'rgba(244, 67, 54, 1)',
                        borderWidth: 1
                    }
                ]
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
                    }
                }
            }
        });

        // Savings Trend Line Chart
        const savingsCtx = document.getElementById('savingsChart').getContext('2d');
        const savingsChart = new Chart(savingsCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($daily_dates); ?>,
                datasets: [{
                    label: 'Cumulative Savings',
                    data: <?php echo json_encode($cumulative_savings); ?>,
                    backgroundColor: 'rgba(33, 150, 243, 0.1)',
                    borderColor: 'rgba(33, 150, 243, 1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
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
                            text: 'Savings (₹)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '₹' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Expense Pie Chart
        const expensePieCtx = document.getElementById('expensePieChart').getContext('2d');
        const expensePieChart = new Chart(expensePieCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($expense_category_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($expense_category_values); ?>,
                    backgroundColor: <?php echo json_encode($expense_colors); ?>,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });

        // Income Pie Chart
        const incomePieCtx = document.getElementById('incomePieChart').getContext('2d');
        const incomePieChart = new Chart(incomePieCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($income_category_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($income_category_values); ?>,
                    backgroundColor: <?php echo json_encode($income_colors); ?>,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    </script>
</body>
</html>

<?php
// Function to generate distinct colors for charts
// Function to generate distinct colors for expense pie chart
function generateExpenseColors($count) {
    $colors = [
        '#FF6B6B', // Red
        '#FFA07A', // Light Salmon
        '#FFD700', // Gold
        '#90EE90', // Light Green
        '#87CEFA', // Light Sky Blue
        '#D8BFD8', // Thistle
        '#FFB6C1', // Light Pink
        '#FF6347', // Tomato
        '#40E0D0', // Turquoise
        '#A0522D', // Sienna
        '#CD5C5C', // Indian Red
        '#20B2AA', // Light Sea Green
    ];

    // If more categories than colors, repeat
    return array_slice(array_pad($colors, $count, $colors[0]), 0, $count);
}

// Function to generate distinct colors for income pie chart
function generateIncomeColors($count) {
    $colors = [
        '#4CAF50', // Green
        '#8BC34A', // Light Green
        '#CDDC39', // Lime
        '#00BCD4', // Cyan
        '#03A9F4', // Light Blue
        '#2196F3', // Blue
        '#3F51B5', // Indigo
        '#673AB7', // Deep Purple
        '#009688', // Teal
        '#607D8B', // Blue Grey
    ];

    return array_slice(array_pad($colors, $count, $colors[0]), 0, $count);
}
?>