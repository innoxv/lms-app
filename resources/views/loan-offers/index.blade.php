<!DOCTYPE html>
<html>
<head>
    <title>Loan Offers</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="loan_offers">
        <div>
            <h1>Create a Loan Offer</h1>
            <form method="POST" action="/loan-offers">
                @csrf
                <label>Loan Type: <input type="text" name="loan_type" required></label><br>
                <label>Interest Rate: <input type="number" step="0.01" name="interest_rate" required></label><br>
                <label>Maximum Amount: <input type="number" step="0.01" name="max_amount" required></label><br>
                <label>Maximum Duration (months): <input type="number" name="max_duration" required></label><br>
                <label>Lender ID: <input type="number" name="lender_id" placeholder="2-6 for testing" required></label><br>
                <button type="submit">SUBMIT</button>
            </form>
        </div>
        <div style="width: 80%;">
            <h2>Loan Offers Information</h2>
              <table class="loan_offers_table">
                <tr>
                    <th>Loan Type</th>
                    <th>Interest Rate</th>
                    <th>Max Amount</th>
                    <th>Max Duration</th>
                    <th>Lender Name</th>
                    <th>Action</th>
                </tr>
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
            </table>
        </div>
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
        // Create modal overlay
        const modalOverlay = document.createElement('div');
        modalOverlay.className = 'modal-overlay';
    
        // Create modal content
        const modalContent = document.createElement('div');
        modalContent.className = 'modal-content';
    
        // Modal HTML
        modalContent.innerHTML = `
            <h2>Edit Loan Offer</h2>
            <form id="editForm">
                <input type="hidden" name="offer_id" value="${data.offerId}">
                <label>Loan Type: <input type="text" name="loan_type" value="${data.loanType}" required></label><br>
                <label>Interest Rate: <input type="number" step="0.01" name="interest_rate" value="${data.interestRate}" required></label><br>
                <label>Maximum Amount: <input type="number" step="0.01" name="max_amount" value="${data.maxAmount}" required></label><br>
                <label>Maximum Duration (months): <input type="number" name="max_duration" value="${data.maxDuration}" required></label><br>
                <div class="modal-action">
                    <button type="submit">Update</button>
                    <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        `;
    
        // Append modal content to overlay and overlay to body
        modalOverlay.appendChild(modalContent);
        document.body.appendChild(modalOverlay);
    
        // Handle form submission
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
</html>