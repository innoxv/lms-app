<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
    <meta charset="UTF-8">
    <title>LMS - Admin Dashboard</title>
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
                        <button type="submit" class="logout">Logout</button>
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
                        <a href="#createLoan">
                        Application Review
                        </a>
                    </li>
                    <li><a href="#viewUsers">View Users</a></li>
                    <li><a href="#addUser">Add New User</a></li>  
                    <li><a href="#activityLogs">Activity Logs</a></li>  
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
                            <h1>Administrator's Dashboard</h1>
                            <p>Welcome, {{ Auth::user()->user_name }} | Role: {{ Auth::user()->role }}</p>
                        </div>
                    </div>
                    <div class="data">
                    <!-- Metrics -->
                    <div class="metrics">
                            <div>
                                <p>Total Users</p>
                                <span>0</span> 
                            </div>
                            <div>
                                <p>Active Users</p>
                                <span>0</span> 
                            </div>
                            <div>
                                <p>Blocked Users</p>
                                <span>0</span> 
                            </div>
                            <div>
                                <p>Total Customers</p>
                                <span>0</span> 
                            </div>
                            <div>
                                <p>Total Lenders</p>
                                <span>0</span> 
                            </div>
                            <div>
                                <p>Total Admins</p>
                                <span>0</span> 
                            </div>
                        </div>
                
                        <!-- Loan Offers Section -->
                        <div class="loan_offers">
                            <div>

                            </div>
                            <div style="width: 100%;">
                                <h2>Loan Offers Information</h2>
                                <table class="loan_offers_table">
                                    <thead>
                                        <tr>
                                            <th>Loan Type</th>
                                            <th>Interest Rate</th>
                                            <th>Max Amount</th>
                                            <th>Max Duration</th>
                                            <th>Lender Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($loanOffers as $offer)
                                        <tr>
                                            <td>{{ $offer->loan_type }}</td>
                                            <td>{{ $offer->interest_rate }}%</td>
                                            <td>{{ $offer->max_amount }}</td>
                                            <td>{{ $offer->max_duration }} months</td>
                                            <td>{{ $offer->lender->name }}</td>
                                            <td>
                                                <input type="hidden" name="offer_id" value="{{ $offer->offer_id }}">
                                                <button class="edit-btn">Edit</button>
                                                <button class="delete-btn">Delete</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> 
                </div>

            </div>
        </div>


        </main>
 
    
    
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Edit functionality
                const editButtons = document.querySelectorAll('.edit-btn');
                editButtons.forEach(button => {
                    button.onclick = function(e) {
                        e.preventDefault();
                        const row = this.parentElement.parentElement;
                        const offerData = {
                            offerId: row.querySelector('input[name="offer_id"]').value,
                            loanType: row.cells[0].textContent,
                            interestRate: parseFloat(row.cells[1].textContent.replace('%', '')),
                            maxAmount: parseFloat(row.cells[2].textContent),
                            maxDuration: parseInt(row.cells[3].textContent.replace(' months', ''))
                        };
                        showEditModal(offerData);
                    };
                });
    
                // Delete functionality
                const deleteButtons = document.querySelectorAll('.delete-btn');
                deleteButtons.forEach(button => {
                    button.onclick = function(e) {
                        e.preventDefault();
                        const row = this.parentElement.parentElement;
                        const offerId = row.querySelector('input[name="offer_id"]').value;
                        
                        if (confirm('Are you sure you want to delete this offer?')) {
                            fetch(`/loan-offers/${offerId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                alert(data.message);
                                window.location.reload();
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Failed to delete offer. Please try again.');
                            });
                        }
                    };
                });
            });
    
            function showEditModal(data) {
                const modalOverlay = document.createElement('div');
                modalOverlay.className = 'modal-overlay';
    
                const modalContent = document.createElement('div');
                modalContent.className = 'modal-content';
    
                modalContent.innerHTML = `
                    <h2>Edit Loan Offer</h2>
                    <form id="editForm">
                        <input type="hidden" name="offer_id" value="${data.offerId}">
                        <label class="block text-sm font-medium">Loan Type: <input type="text" name="loan_type" value="${data.loanType}" required class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white"></label><br>
                        <label class="block text-sm font-medium">Interest Rate: <input type="number" step="0.01" name="interest_rate" value="${data.interestRate}" required class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white"></label><br>
                        <label class="block text-sm font-medium">Maximum Amount: <input type="number" step="0.01" name="max_amount" value="${data.maxAmount}" required class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white"></label><br>
                        <label class="block text-sm font-medium">Maximum Duration (months): <input type="number" name="max_duration" value="${data.maxDuration}" required class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white"></label><br>
                        <div class="modal-action">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Update</button>
                            <button type="button" class="cancel-btn text-red-400 hover:underline" onclick="closeModal()">Cancel</button>
                        </div>
                    </form>
                `;
    
                modalOverlay.appendChild(modalContent);
                document.body.appendChild(modalOverlay);
    
                const editForm = document.getElementById('editForm');
                editForm.onsubmit = function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    fetch('/loan-offers/' + data.offerId, {
                        method: 'PATCH',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(error => {
                                throw new Error(error.message || 'Update failed');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert(data.message);
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to update offer. Please try again.');
                    });
                };
            }
    
            function closeModal() {
                const modal = document.querySelector('.modal-overlay');
                if (modal) {
                    modal.remove();
                }
            }
        </script>

</body>
</html>