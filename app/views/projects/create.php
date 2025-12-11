<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<style>
.team-member-row {
    background-color: #2d3748;
    border: 1px solid #4a5568 !important;
    transition: all 0.2s ease;
    color: #e2e8f0;
}

.team-member-row:hover {
    background-color: #4a5568;
    border-color: #718096 !important;
}

.team-member-row .form-label {
    color: #e2e8f0 !important;
}

.team-member-row .form-select {
    background-color: #4a5568 !important;
    border-color: #718096 !important;
    color: #e2e8f0 !important;
}

.team-member-row .form-select:focus {
    background-color: #4a5568 !important;
    border-color: #63b3ed !important;
    color: #e2e8f0 !important;
    box-shadow: 0 0 0 0.2rem rgba(99, 179, 237, 0.25) !important;
}

.team-member-row .form-select option {
    background-color: #4a5568;
    color: #e2e8f0;
}

.team-member-row .remove-member {
    opacity: 0.7;
    transition: opacity 0.2s ease;
    background-color: #e53e3e;
    border-color: #e53e3e;
    color: white;
}

.team-member-row .remove-member:hover {
    opacity: 1;
    background-color: #c53030;
    border-color: #c53030;
}

.team-member-row .remove-member:disabled {
    opacity: 0.3;
    cursor: not-allowed;
    background-color: #718096;
    border-color: #718096;
}

#add-team-member {
    border-style: dashed;
    border-width: 2px;
    transition: all 0.2s ease;
    background-color: transparent;
    border-color: #63b3ed;
    color: #63b3ed;
}

#add-team-member:hover {
    background-color: #2b6cb0;
    border-color: #2b6cb0;
    color: white;
}

.form-label {
    color: #e2e8f0 !important;
}

.text-muted {
    color: #a0aec0 !important;
}

/* Project Creator Card Styling */
.project-creator-card {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

[data-theme="dark"] .project-creator-card {
    background-color: #2d3748;
    border-color: #4a5568;
}


.crown-icon {
    color: #fbbf24;
    font-size: 18px;
}
</style>

<!-- Projects Create Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-light">Buat Proyek Baru</h1>
        <p class="text-muted mb-0">Tambahkan proyek baru ke workspace Anda</p>
    </div>
    <a href="index.php?url=projects" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Proyek
    </a>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <h6>Perbaiki kesalahan berikut:</h6>
    <ul class="mb-0">
        <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <i class="fas fa-project-diagram me-2"></i>
                    Informasi Proyek
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nama Proyek <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="client_name" class="form-label">Klien</label>
                            <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Nama klien (opsional)"
                                   value="<?php echo htmlspecialchars($_POST['client_name'] ?? ''); ?>">
                            <small class="text-muted">Biarkan kosong jika tidak ada klien.</small>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Pembuat Proyek</label>
                            <div class="card project-creator-card">
                                <div class="card-body py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="fw-medium"><?php echo htmlspecialchars($currentUser['full_name']); ?></div>
                                            <small class="text-muted">Pembuat Proyek (<?php echo ucfirst(str_replace('_', ' ', $currentUser['role'])); ?>)</small>
                                        </div>
                                        <div class="crown-icon">
                                            <i class="fas fa-crown"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-1">Anda otomatis ditetapkan sebagai pembuat proyek dan manajer proyek utama.</small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Anggota Tim Tambahan</label>
                            <div id="project-team-container">
                                <!-- Additional team members will be added here dynamically -->
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-team-member">
                                <i class="fas fa-plus me-1"></i>Tambah Anggota Tim
                            </button>
                            <small class="text-muted d-block mt-1">Tambahkan anggota tim tambahan yang akan terlibat dalam proyek ini.</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="<?php echo htmlspecialchars($_POST['start_date'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="<?php echo htmlspecialchars($_POST['end_date'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <!-- Removed Status, Priority, and Budget fields as requested -->

                    <div class="d-flex justify-content-end gap-3">
                        <a href="index.php?url=projects" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Buat Proyek
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <i class="fas fa-info-circle me-2"></i>
                    Panduan Proyek
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">
                        <i class="fas fa-lightbulb me-2"></i>Tips Sukses
                    </h6>
                    <ul class="small text-muted mb-0">
                        <li>Pilih nama proyek yang jelas dan deskriptif</li>
                        <li>Berikan deskripsi proyek yang detail</li>
                        <li>Tetapkan tanggal mulai dan selesai yang realistis</li>
                        <li>Tetapkan manajer proyek yang sesuai</li>
                        <li>Tentukan prioritas proyek yang jelas</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">
                        <i class="fas fa-users me-2"></i>Peran & Izin
                    </h6>
                    <small class="text-muted">
                        Hanya Admin dan Manajer Proyek yang dapat membuat proyek baru.
                        Manajer Proyek yang ditetapkan akan memiliki akses penuh untuk mengelola proyek.
                    </small>
                </div>

                <div>
                    <h6 class="text-primary">
                        <i class="fas fa-chart-line me-2"></i>Pelacakan Proyek
                    </h6>
                    <small class="text-muted">
                        Progress proyek akan dihitung otomatis berdasarkan tugas yang selesai.
                        Anda dapat melacak milestone dan tenggat waktu dari dashboard proyek.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const teamContainer = document.getElementById('project-team-container');
    const addButton = document.getElementById('add-team-member');
    let teamMemberCount = 0;
    
    // Available users data from PHP
    const availableUsers = <?php echo json_encode($allUsers ?? []); ?>;
    
    // Add initial team member if auto-selected
    <?php if (isset($autoSelectedManagerId) && $autoSelectedManagerId): ?>
        addTeamMember(<?php echo $autoSelectedManagerId; ?>, 'project_manager');
    <?php else: ?>
        addTeamMember();
    <?php endif; ?>
    
    addButton.addEventListener('click', function() {
        addTeamMember();
    });
    
    function addTeamMember(selectedUserId = null, selectedRole = 'developer') {
        teamMemberCount++;
        const memberDiv = document.createElement('div');
        memberDiv.className = 'team-member-row mb-3 p-3 border rounded';
        memberDiv.innerHTML = `
            <div class="row align-items-end">
                <div class="col-md-5">
                    <label class="form-label">Anggota Tim</label>
                    <select class="form-select team-member-select" name="team_members[${teamMemberCount}][user_id]" required>
                        <option value="">Pilih Anggota Tim</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Peran dalam Proyek</label>
                    <select class="form-select team-role-select" name="team_members[${teamMemberCount}][role]" required>
                        <option value="developer" ${selectedRole === 'developer' ? 'selected' : ''}>Pengembang</option>
                        <option value="qa_tester" ${selectedRole === 'qa_tester' ? 'selected' : ''}>QA Tester</option>
                        <option value="project_manager" ${selectedRole === 'project_manager' ? 'selected' : ''}>Manajer Proyek</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-member" ${teamMemberCount === 1 ? 'disabled' : ''}>
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        
        teamContainer.appendChild(memberDiv);
        
        // Get the select elements
        const roleSelect = memberDiv.querySelector('.team-role-select');
        const memberSelect = memberDiv.querySelector('.team-member-select');
        
        // Function to update member options based on selected role
        function updateMemberOptions() {
            const selectedRole = roleSelect.value;
            memberSelect.innerHTML = '<option value="">Pilih Anggota Tim</option>';
            
            if (selectedRole) {
                const currentUserId = <?php echo $currentUser['id']; ?>;
                let filteredUsers;
                
                if (selectedRole === 'project_manager') {
                    // For project manager role, show users with project_manager role
                    filteredUsers = availableUsers.filter(user => 
                        user.role === 'project_manager' && user.id != currentUserId
                    );
                } else {
                    // For other roles, show users with matching role
                    filteredUsers = availableUsers.filter(user => 
                        user.role === selectedRole && user.id != currentUserId
                    );
                }
                
                filteredUsers.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.id;
                    option.textContent = `${user.full_name} (${user.role})`;
                    if (selectedUserId == user.id) {
                        option.selected = true;
                    }
                    memberSelect.appendChild(option);
                });
            }
        }
        
        // Add event listener for role change
        roleSelect.addEventListener('change', function() {
            updateMemberOptions();
        });
        
        // Initial load
        updateMemberOptions();
        
        // Add remove functionality
        const removeBtn = memberDiv.querySelector('.remove-member');
        removeBtn.addEventListener('click', function() {
            if (teamMemberCount > 1) {
                memberDiv.remove();
                teamMemberCount--;
                updateRemoveButtons();
            }
        });
        
        updateRemoveButtons();
    }
    
    function updateRemoveButtons() {
        const removeButtons = teamContainer.querySelectorAll('.remove-member');
        removeButtons.forEach((btn, index) => {
            btn.disabled = removeButtons.length === 1;
        });
    }
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const teamMembers = teamContainer.querySelectorAll('.team-member-select');
        const hasEmptyMembers = Array.from(teamMembers).some((select, index) => {
            const roleSelect = teamContainer.querySelectorAll('.team-role-select')[index];
            return select.value && !roleSelect.value || !select.value && roleSelect.value;
        });
        
        if (hasEmptyMembers) {
            e.preventDefault();
            alert('Harap lengkapi pilihan anggota tim (pengguna dan peran harus dipilih).');
            return false;
        }
    });
});
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>