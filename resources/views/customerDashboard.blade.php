<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
    <meta charset="UTF-8">
    <title>LMS - Customer Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <main>
    <div class="header">
        <div class="header2">
            <div class="logo">LMS</div>    
        </div>
        <div class="header4">
            <!-- Message Toast section -->
            <div>
                <!-- Message Functionality -->
                <div id="loan-message"></div>
            </div>
            <div>
                    <!-- Logout -->
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="logout" >Logout</button>
                    </form>
            </div>
        </div>
    </div>
    <div class="customer-content">
        <div class="nav">
            <ul class="nav-split">
                <div class="top">
                    <li><a href="#dashboard">Dashboard</a></li>
                    <li>
                        <a href="#applyLoan" 
                        class="">
                        Apply Loan
                        </a>
                    </li>
                    <li><a href="#loanHistory">Loan History</a></li>
                    <li><a href="#paymentTracking">Payment Tracking</a></li>  
                    <li><a href="#transactionHistory">Transaction History</a></li>  
                    <li><a href="#profile">Profile</a></li>
                </div>
                <div class="bottom">
                    <!-- <li><a href="#feedback">Feedback</a></li> -->
                    <li><a href="#contactSupport">Help</a></li>
                        <!-- Copyright -->
                        <div class="copyright">
                            <div>&copy; 2025</div>
                        </div>
                </div>
            </ul>
            </div>
            <div class="display">
                <div id="dashboard" class="margin">
                    <div class="dash-header">
                        <div>
                            <h1>Customer's Dashboard</h1>
                            <p>Welcome, {{ Auth::user()->user_name }} | Role: {{ Auth::user()->role }}</p>
                        </div>
                    </div>
                    <div class="data">
                        <!-- Metrics -->
                        <div class="metrics">
                                <div>
                                    <p>Active Loans</p>
                                    <span>0</span> 
                                </div>
                                <div>
                                    <p>Disbursed Loans</p>
                                    <span>0</span> 
                                </div>
                                <div>
                                    <p>Amount Borrowed</p>
                                    <span>0</span> 
                                </div>
                                <div>
                                    <p>Outstanding Balance</p>
                                    <span>0</span> 
                                </div>
                                <div>
                                    <p>Next Payment Date</p>
                                    <span>N/A</span> 
                                </div>
                            </div>
                
                        <div class="dash-sec">
                            <!-- Loan Applications Section -->
                            <div class="">
                                <h2 class="text-xl font-semibold mb-2">Loan Applications</h2>
                                <table class="loan_offers_table">
                                    <thead>
                                        <tr>
                                            <th class="p-2">Amount</th>
                                            <th class="p-2">Status</th>
                                            <th class="p-2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <tr><td colspan="3" class="p-2 text-center">No applications available</td></tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Payment Tracking Section -->
                            <div>
                                <h2 class="text-xl font-semibold mb-2">Payment Tracking</h2>
                                <table class="loan_offers_table">
                                    <thead>
                                        <tr>
                                            <th class="p-2">Loan ID</th>
                                            <th class="p-2">Amount Due</th>
                                            <th class="p-2">Amount Paid</th>
                                            <th class="p-2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Populate with dynamic data -->
                                        <tr><td colspan="4" class="p-2 text-center">No payments available</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>


        </main>
</body>
</html>





