<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>LMS - Lender Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: #1f2937;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            color: white;
        }
        .modal-action button {
            margin-right: 10px;
        }
        .loan_offers_table th, .loan_offers_table td {
            padding: 8px;
            text-align: left;
        }
        .loan_offers_table th {
            background: #374151;
        }
        .loan_offers_table tr:nth-child(even) {
            background: #4b5563;
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Lender Dashboard</h1>
        <p>Welcome, {{ Auth::user()->user_name }} (Role: {{ Auth::user()->role }})</p>

        <!-- Metrics -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-800 p-4 rounded">
                <h2 class="text-lg font-semibold">Total Loans</h2>
                <p class="text-2xl">0.00</p> <!-- Replace with dynamic data -->
            </div>
            <div class="bg-gray-800 p-4 rounded">
                <h2 class="text-lg font-semibold">Avg. Interest Rate</h2>
                <p class="text-2xl">0.00%</p> <!-- Replace with dynamic data -->
            </div>
        </div>

        <!-- Loan Offers Section -->
        <div class="loan_offers">
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Create a Loan Offer</h2>
                <form method="POST" action="{{ route('loan-offers.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium">Loan Type: <input type="text" name="loan_type" required class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white"></label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Interest Rate: <input type="number" step="0.01" name="interest_rate" required class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white"></label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Maximum Amount: <input type="number" step="0.01" name="max_amount" required class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white"></label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Maximum Duration (months): <input type="number" name="max_duration" required class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white"></label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Lender ID: <input type="number" name="lender_id" value="{{ Auth::user()->lender->lender_id }}" readonly class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white"></label>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">SUBMIT</button>
                </form>
            </div>
            <div class="mb-6" style="width: 100%;">
                <h2 class="text-xl font-semibold mb-2">Loan Offers Information</h2>
                <table class="loan_offers_table w-full">
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
                                <button class="edit-btn text-blue-400 hover:underline">Edit</button>
                                <button class="delete-btn text-red-400 hover:underline">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="text-blue-400 hover:underline">Logout</button>
        </form>
    </div>

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