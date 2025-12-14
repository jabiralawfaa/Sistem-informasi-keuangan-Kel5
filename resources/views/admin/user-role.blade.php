@extends('layouts.app')

@section('title', 'User Role Management')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-amber-400">User Role Management</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-900/30 border border-green-700 text-green-400 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-gray-800 rounded-xl border border-amber-900 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="py-3 px-4 text-left text-gray-400">Name</th>
                            <th class="py-3 px-4 text-left text-gray-400">Email</th>
                            <th class="py-3 px-4 text-left text-gray-400">Verified At</th>
                            <th class="py-3 px-4 text-left text-gray-400">Role</th>
                            <th class="py-3 px-4 text-left text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="border-b border-gray-700 hover:bg-gray-750">
                            <td class="py-3 px-4">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">{{ $user->email_verified_at ? $user->email_verified_at->format('d M Y H:i') : 'Not Verified' }}</td>
                            <td class="py-3 px-4">
                                <span class="role-tag cursor-pointer px-2 py-1 bg-gray-700 rounded text-sm hover:bg-amber-600 transition duration-200" 
                                      data-user-id="{{ $user->id }}" 
                                      data-current-role="{{ $user->role }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <button 
                                    type="button" 
                                    class="role-edit-btn text-amber-400 hover:text-amber-300 ml-2"
                                    data-user-id="{{ $user->id }}" 
                                    data-current-role="{{ $user->role }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 px-4 text-center text-gray-500">
                                No pending users found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-700">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Role Selection Modal -->
    <div id="roleModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-gray-800 rounded-xl border border-amber-900 p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-amber-400">Assign Role</h2>
                <button id="closeModal" class="text-gray-400 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="mb-6">
                <p class="text-gray-300 mb-2">Select a role for <span id="userNameModal" class="font-semibold text-amber-400"></span>:</p>
                
                <div class="space-y-3">
                    <button class="role-option w-full text-left px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400" data-role="admin">
                        Admin
                    </button>
                    <button class="role-option w-full text-left px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400" data-role="bendahara">
                        Bendahara
                    </button>
                    <button class="role-option w-full text-left px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400" data-role="auditor">
                        Auditor
                    </button>
                    <button class="role-option w-full text-left px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400" data-role="guest">
                        Guest (No Access)
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden form for AJAX -->
    <form id="roleForm" method="POST" style="display: none;">
        @csrf
        @method('PUT')
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('roleModal');
    const closeModal = document.getElementById('closeModal');
    const userNameModal = document.getElementById('userNameModal');
    const roleOptions = document.querySelectorAll('.role-option');
    const roleEditBtns = document.querySelectorAll('.role-edit-btn');
    const roleTags = document.querySelectorAll('.role-tag');
    const roleForm = document.getElementById('roleForm');
    
    let selectedUserId = null;
    let selectedUserName = null;

    // Event listener for role edit buttons
    roleEditBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const userName = this.closest('tr').querySelector('td:first-child').textContent;
            selectedUserId = userId;
            selectedUserName = userName;
            userNameModal.textContent = userName;
            modal.classList.remove('hidden');
        });
    });

    // Event listener for role tags (click to edit)
    roleTags.forEach(tag => {
        tag.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const userName = this.closest('tr').querySelector('td:first-child').textContent;
            selectedUserId = userId;
            selectedUserName = userName;
            userNameModal.textContent = userName;
            modal.classList.remove('hidden');
        });
    });

    // Event listener for role options
    roleOptions.forEach(option => {
        option.addEventListener('click', function() {
            const newRole = this.getAttribute('data-role');

            // Create and send AJAX request with proper CSRF token and POST method for InfinityFree compatibility
            fetch(`/admin/users/${selectedUserId}/role`, {
                method: 'POST', // Changed to POST for better compatibility with shared hosting
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-HTTP-Method-Override': 'PUT'
                },
                body: JSON.stringify({
                    role: newRole,
                    _method: 'PUT' // Explicitly include method override in payload
                })
            })
            .then(response => {
                if (!response.ok) {
                    // If response is not OK, throw an error
                    if (response.status === 419) {
                        // CSRF token mismatch
                        throw new Error('Session expired. Please refresh the page and try again.');
                    }
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update the role tag in the table
                    document.querySelectorAll(`[data-user-id="${selectedUserId}"]`).forEach(element => {
                        if (element.classList.contains('role-tag')) {
                            element.textContent = newRole.charAt(0).toUpperCase() + newRole.slice(1);
                            element.setAttribute('data-current-role', newRole);
                        }
                    });

                    alert(data.message || 'Role updated successfully!');
                    modal.classList.add('hidden');
                } else {
                    alert(data.message || 'Error updating role');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating role: ' + error.message);
            });
        });
    });

    // Event listener for close modal
    closeModal.addEventListener('click', function() {
        modal.classList.add('hidden');
    });
    
    // Close modal when clicking outside of it
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
</script>
@endsection