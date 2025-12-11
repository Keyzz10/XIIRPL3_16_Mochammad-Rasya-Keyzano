    <?php if (isset($_SESSION['user_id'])): ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle sidebar functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarLogo = document.getElementById('sidebar-logo');
            const overlay = document.getElementById('sidebar-overlay');
            
            // Check if we're on mobile
            if (window.innerWidth <= 767.98) {
                // Mobile behavior
                sidebar.classList.toggle('show');
                if (overlay) {
                    overlay.classList.toggle('show');
                }
            } else {
                // Desktop behavior
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                
                // Toggle logo visibility
                if (sidebar.classList.contains('collapsed')) {
                    sidebarLogo.classList.remove('d-none');
                } else {
                    sidebarLogo.classList.add('d-none');
                }
            }
        }
        
        // Close mobile sidebar when clicking overlay
        function closeMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.remove('show');
            if (overlay) {
                overlay.classList.remove('show');
            }
        }
        
        // Handle window resize
        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (window.innerWidth <= 767.98) {
                // Mobile mode
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
                if (overlay) {
                    overlay.classList.remove('show');
                }
            } else {
                // Desktop mode
                sidebar.classList.remove('show');
                if (overlay) {
                    overlay.classList.remove('show');
                }
            }
        }
        
        // Dark mode toggle
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            
            // Save preference to localStorage
            const isDarkMode = document.body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDarkMode);
        }
        
        // Modern Logout confirmation modal (use Bootstrap modal design)
        function confirmLogout(event) {
            if (event && typeof event.preventDefault === 'function') {
                event.preventDefault();
            }
            
            console.log('confirmLogout called');
            
            // Always try to show modal first
            const modal = document.getElementById('logoutModal');
            console.log('Modal element:', modal);
            console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
            
            if (modal) {
                try {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        console.log('Showing Bootstrap modal');
                        const bootstrapModal = new bootstrap.Modal(modal, {
                            backdrop: true,
                            keyboard: true,
                            focus: true
                        });
                        bootstrapModal.show();
                        return false;
                    } else {
                        console.log('Bootstrap not available, showing modal manually');
                        // Create backdrop
                        const backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade';
                        backdrop.id = 'manualBackdrop';
                        document.body.appendChild(backdrop);
                        
                        // Show modal with animation
                        modal.style.display = 'block';
                        modal.classList.add('show');
                        document.body.classList.add('modal-open');
                        
                        // Trigger animation
                        setTimeout(() => {
                            backdrop.classList.add('show');
                        }, 10);
                        
                        // Handle backdrop click
                        backdrop.addEventListener('click', () => {
                            hideModal();
                        });
                        
                        return false;
                    }
                } catch (err) {
                    console.error('Modal show failed:', err);
                }
            } else {
                console.log('Modal element not found');
            }
            
            // Only redirect if modal completely fails
            console.log('Falling back to direct logout');
            window.location.href = 'index.php?url=logout';
            return false;
        }
        
        // Manual modal hide function
        function hideModal() {
            const modal = document.getElementById('logoutModal');
            const backdrop = document.getElementById('manualBackdrop');
            
            // Try Bootstrap modal first
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                const bootstrapModal = bootstrap.Modal.getInstance(modal);
                if (bootstrapModal) {
                    bootstrapModal.hide();
                    return;
                }
            }
            
            // Fallback to manual hide
            if (modal) {
                modal.classList.remove('show');
                document.body.classList.remove('modal-open');
                
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
            }
            
            if (backdrop) {
                backdrop.classList.remove('show');
                setTimeout(() => {
                    backdrop.remove();
                }, 300);
            }
        }
        
        function proceedLogout() {
            // Add loading effect
            const logoutBtn = document.getElementById('confirmLogoutBtn');
            const cancelBtn = document.getElementById('cancelLogoutBtn');
            
            logoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i><?php echo addslashes(__('common.loading')); ?>';
            logoutBtn.disabled = true;
            cancelBtn.disabled = true;
            
            // Hide modal with animation before redirect
            hideModal();
            
            // Redirect after animation completes
            setTimeout(() => {
                window.location.href = 'index.php?url=logout';
            }, 300);
        }
        
        // Load dark mode preference and initialize responsive behavior
        document.addEventListener('DOMContentLoaded', function() {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'true') {
                document.body.classList.add('dark-mode');
            }
            
            // Initialize responsive behavior
            handleResize();
            
            // Add resize event listener
            window.addEventListener('resize', handleResize);
            
            // Close mobile sidebar when clicking on nav links
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 767.98) {
                        closeMobileSidebar();
                    }
                });
            });
            
            // Add event listeners for modal buttons
            const cancelBtn = document.getElementById('cancelLogoutBtn');
            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    hideModal();
                });
            }
            
            // Handle Bootstrap modal events
            const modal = document.getElementById('logoutModal');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', function() {
                    // Reset button states when modal is closed
                    const logoutBtn = document.getElementById('confirmLogoutBtn');
                    const cancelBtn = document.getElementById('cancelLogoutBtn');
                    if (logoutBtn) {
                        logoutBtn.innerHTML = '<i class="fas fa-sign-out-alt me-2"></i><?php echo addslashes(__('nav.logout')); ?>';
                        logoutBtn.disabled = false;
                    }
                    if (cancelBtn) {
                        cancelBtn.disabled = false;
                    }
                });
            }
        });
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 5000);
            });
        });
        
        // Loading overlay functions
        function showLoading() {
            document.getElementById('loading').classList.remove('d-none');
        }
        
        function hideLoading() {
            document.getElementById('loading').classList.add('d-none');
        }
        
        
        // Show loading on form submits
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(function(form) {
                form.addEventListener('submit', function() {
                    showLoading();
                });
            });
            
            // Initialize Bootstrap dropdowns with debugging
            console.log('Initializing dropdowns...');
            console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
            
            const dropdownToggleEls = document.querySelectorAll('[data-bs-toggle="dropdown"]');
            console.log('Found dropdowns:', dropdownToggleEls.length);
            
            dropdownToggleEls.forEach(function(dropdownToggleEl) {
                console.log('Initializing dropdown:', dropdownToggleEl);
                
                // Initialize Bootstrap dropdown
                if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
                    new bootstrap.Dropdown(dropdownToggleEl);
                } else {
                    console.warn('Bootstrap not available, adding manual dropdown handling');
                    
                    // Manual dropdown toggle as fallback
                    dropdownToggleEl.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        const dropdownMenu = this.nextElementSibling;
                        const isExpanded = this.getAttribute('aria-expanded') === 'true';
                        
                        console.log('Dropdown clicked, isExpanded:', isExpanded);
                        
                        // Toggle dropdown
                        if (dropdownMenu) {
                            if (isExpanded) {
                                dropdownMenu.classList.remove('show');
                                this.setAttribute('aria-expanded', 'false');
                            } else {
                                dropdownMenu.classList.add('show');
                                this.setAttribute('aria-expanded', 'true');
                            }
                        }
                    });
                    
                    // Close dropdown when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!dropdownToggleEl.contains(e.target) && 
                            !dropdownToggleEl.nextElementSibling.contains(e.target)) {
                            const dropdownMenu = dropdownToggleEl.nextElementSibling;
                            if (dropdownMenu) {
                                dropdownMenu.classList.remove('show');
                                dropdownToggleEl.setAttribute('aria-expanded', 'false');
                            }
                        }
                    });
                }
            });
            
            console.log('Dropdown initialization complete');
        });
    </script>
</body>
</html>