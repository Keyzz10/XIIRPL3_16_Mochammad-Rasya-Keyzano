<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<!-- Bug Report Create/Edit Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark"><?php echo !empty($isEdit) ? __('bugs.edit_title') : __('bugs.create_title'); ?></h1>
        <p class="text-muted mb-0"><?php echo !empty($isEdit) ? __('bugs.edit_subtitle') : __('bugs.create_subtitle'); ?></p>
    </div>
    <a href="index.php?url=bugs" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i><?php _e('bugs.back_to_list'); ?>
    </a>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <h6><?php _e('bugs.fix_errors'); ?></h6>
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
                    <i class="fas fa-bug me-2"></i>
                    <?php _e('bugs.info_section'); ?>
                </h5>
            </div>
            <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="project_id" class="form-label"><?php _e('bugs.field_project'); ?> <span class="text-danger">*</span></label>
                            <select class="form-select" id="project_id" name="project_id" required <?php echo !empty($isEdit) ? 'disabled' : ''; ?>>
                                <option value=""><?php _e('bugs.select_project'); ?></option>
                                <?php if (!empty($projects)): ?>
                                    <?php foreach ($projects as $project): ?>
                                        <option value="<?php echo $project['id']; ?>" 
                                                <?php
                                                    $selectedProject = $_POST['project_id'] ?? ($_GET['project_id'] ?? ($bug['project_id'] ?? ''));
                                                    echo ($selectedProject == $project['id']) ? 'selected' : '';
                                                ?>>
                                            <?php echo htmlspecialchars($project['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="task_id" class="form-label"><?php _e('bugs.field_related_task'); ?></label>
                            <select class="form-select" id="task_id" name="task_id">
                                <option value=""><?php _e('bugs.no_related_task'); ?></option>
                                <!-- Tasks will be loaded dynamically based on selected project -->
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label"><?php _e('bugs.field_title'); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo htmlspecialchars($_POST['title'] ?? ($_GET['title'] ?? ($bug['title'] ?? ''))); ?>" 
                               placeholder="<?php echo __('bugs.placeholder_title'); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label text-dark"><?php _e('bugs.field_description'); ?> <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="4" 
                                  placeholder="<?php echo __('bugs.placeholder_description'); ?>" required><?php echo htmlspecialchars($_POST['description'] ?? ($_GET['description'] ?? ($bug['description'] ?? ''))); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="steps_to_reproduce" class="form-label text-dark"><?php _e('bugs.field_steps'); ?> <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="steps_to_reproduce" name="steps_to_reproduce" rows="4" 
                                  placeholder="<?php echo __('bugs.placeholder_steps'); ?>" required><?php echo htmlspecialchars($_POST['steps_to_reproduce'] ?? ($bug['steps_to_reproduce'] ?? '')); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="expected_result" class="form-label text-dark"><?php _e('bugs.field_expected'); ?> <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="expected_result" name="expected_result" rows="3" 
                                      placeholder="<?php echo __('bugs.placeholder_expected'); ?>" required><?php echo htmlspecialchars($_POST['expected_result'] ?? ($_GET['expected_result'] ?? ($bug['expected_result'] ?? ''))); ?></textarea>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="actual_result" class="form-label text-dark"><?php _e('bugs.field_actual'); ?> <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="actual_result" name="actual_result" rows="3" 
                                      placeholder="<?php echo __('bugs.placeholder_actual'); ?>" required><?php echo htmlspecialchars($_POST['actual_result'] ?? ($bug['actual_result'] ?? '')); ?></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="category_id" class="form-label text-dark"><?php _e('bugs.field_category'); ?> <span class="text-danger">*</span></label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value=""><?php _e('bugs.select_category'); ?></option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" 
                                                <?php
                                                    $selectedCat = $_POST['category_id'] ?? ($bug['category_id'] ?? '');
                                                    echo ($selectedCat == $category['id']) ? 'selected' : '';
                                                ?>>
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1">UI</option>
                                    <option value="2">Backend</option>
                                    <option value="3">Database</option>
                                    <option value="4"><?php _e('bugs.category_performance'); ?></option>
                                    <option value="5"><?php _e('bugs.category_security'); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="severity" class="form-label text-dark"><?php _e('bugs.field_severity'); ?> <span class="text-danger">*</span></label>
                            <select class="form-select" id="severity" name="severity" required>
                                <option value=""><?php _e('bugs.select_severity'); ?></option>
                                <?php $sevSel = $_POST['severity'] ?? ($bug['severity'] ?? ''); ?>
                                <option value="critical" <?php echo $sevSel == 'critical' ? 'selected' : ''; ?>>Kritis</option>
                                <option value="major" <?php echo $sevSel == 'major' ? 'selected' : ''; ?>>Mayor</option>
                                <option value="minor" <?php echo $sevSel == 'minor' ? 'selected' : ''; ?>>Minor</option>
                                <option value="trivial" <?php echo $sevSel == 'trivial' ? 'selected' : ''; ?>>Trivial</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="priority" class="form-label text-dark"><?php _e('bugs.field_priority'); ?> <span class="text-danger">*</span></label>
                            <select class="form-select" id="priority" name="priority" required>
                                <option value=""><?php _e('bugs.select_priority'); ?></option>
                                <?php $prioSel = $_POST['priority'] ?? ($bug['priority'] ?? ''); ?>
                                <option value="low" <?php echo $prioSel == 'low' ? 'selected' : ''; ?>><?php _e('bugs.prio_low'); ?></option>
                                <option value="medium" <?php echo $prioSel == 'medium' ? 'selected' : ''; ?>><?php _e('bugs.prio_medium'); ?></option>
                                <option value="high" <?php echo $prioSel == 'high' ? 'selected' : ''; ?>><?php _e('bugs.prio_high'); ?></option>
                                <option value="urgent" <?php echo $prioSel == 'urgent' ? 'selected' : ''; ?>><?php _e('bugs.prio_urgent'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="assigned_to" class="form-label text-dark">Assign to Developer</label>
                            <select class="form-select" id="assigned_to" name="assigned_to">
                                <option value="">Select Developer (Optional)</option>
                                <?php 
                                $developers = array_filter($users ?? [], function($u) { return ($u['role'] ?? '') === 'developer'; });
                                foreach ($developers as $dev): ?>
                                    <option value="<?php echo $dev['id']; ?>" 
                                            <?php echo (($_POST['assigned_to'] ?? ($bug['assigned_to'] ?? '')) == $dev['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($dev['full_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="due_date" class="form-label text-dark">Due Date / SLA</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" 
                                   value="<?php echo htmlspecialchars($_POST['due_date'] ?? ($bug['due_date'] ?? '')); ?>">
                            <div class="form-text text-muted">Based on priority: Critical (24h), High (3 days), Medium (1 week), Low (2 weeks)</div>
                        </div>
                    </div>

                    <?php if (!empty($isEdit) && !empty($attachments)): ?>
  <div class="mb-3">
    <label class="form-label fw-bold">Lampiran saat ini:</label>
    <div class="d-flex flex-wrap gap-3">
      <?php foreach ($attachments as $att): ?>
        <?php 
          $nameOrPath = (string)($att['file_name'] ?? $att['file_path'] ?? '');
          $isImg = preg_match('/\.(png|jpe?g|gif|webp)$/i', $nameOrPath) === 1;
          $filepath = $att['file_path'] ?? '';
          if (strpos($filepath, '/') !== 0) $filepath = '/' . $filepath;
        ?>
        <div style="min-width:90px;max-width:140px;">
          <a href="<?php echo htmlspecialchars($filepath); ?>" target="_blank" class="text-decoration-none">
            <?php if ($isImg): ?>
              <img src="<?php echo htmlspecialchars($filepath); ?>" alt="attachment" class="img-fluid rounded bg-light" style="max-width:120px;max-height:90px;object-fit:cover;border:1px solid #bbb;">
            <?php else: ?>
              <span class="badge bg-secondary"><i class="fas fa-paperclip me-1"></i> <?php echo htmlspecialchars($att['file_name'] ?? basename($att['file_path'])); ?></span>
            <?php endif; ?>
            <div class="small mt-1 text-break">
              <?php echo htmlspecialchars($att['file_name'] ?? basename($att['file_path'])); ?>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="form-text text-muted">Lampiran baru akan ditambahkan ke sini. Biarkan kosong jika tidak ingin menambah lampiran baru.</div>
  </div>
<?php endif; ?>

                    <div class="mb-3">
                        <label for="attachments" class="form-label text-dark">Attachments <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="attachments" name="attachments[]" 
                               accept="image/*,video/*,.log,.txt,.pdf" multiple required>
                        <div class="form-text text-muted">
                            <strong>Required:</strong> Upload screenshots, screen recordings, or log files. 
                            Supported formats: Images, Videos, Log files, PDF
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="browser" class="form-label"><?php _e('bugs.field_browser'); ?></label>
                            <input type="text" class="form-control" id="browser" name="browser" 
                                   value="<?php echo htmlspecialchars($_POST['browser'] ?? ($bug['browser'] ?? '')); ?>" 
                                   placeholder="<?php echo __('bugs.placeholder_browser'); ?>">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="os" class="form-label"><?php _e('bugs.field_os'); ?></label>
                            <input type="text" class="form-control" id="os" name="os" 
                                   value="<?php echo htmlspecialchars($_POST['os'] ?? ($bug['os'] ?? '')); ?>" 
                                   placeholder="<?php echo __('bugs.placeholder_os'); ?>">
                        </div>
                        
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <a href="index.php?url=bugs" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i><?php _e('common.cancel'); ?>
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-bug me-2"></i><?php echo !empty($isEdit) ? __('common.save') : __('bugs.report_bug'); ?>
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
                    <?php _e('bugs.guidelines_title'); ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">
                        <i class="fas fa-lightbulb me-2"></i><?php _e('bugs.guidelines_effective_title'); ?>
                    </h6>
                    <ul class="small text-muted mb-0">
                        <li><?php _e('bugs.tip_clear_titles'); ?></li>
                        <li><?php _e('bugs.tip_steps'); ?></li>
                        <li><?php _e('bugs.tip_expected_actual'); ?></li>
                        <li><?php _e('bugs.tip_env_info'); ?></li>
                        <li><?php _e('bugs.tip_screenshots'); ?></li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">
                        <i class="fas fa-exclamation-triangle me-2"></i><?php _e('bugs.guidelines_severity_title'); ?>
                    </h6>
                    <small class="text-muted">
                        <strong><?php _e('bugs.sev_critical'); ?>:</strong> <?php _e('bugs.sev_critical_desc'); ?><br>
                        <strong><?php _e('bugs.sev_high'); ?>:</strong> <?php _e('bugs.sev_high_desc'); ?><br>
                        <strong><?php _e('bugs.sev_medium'); ?>:</strong> <?php _e('bugs.sev_medium_desc'); ?><br>
                        <strong><?php _e('bugs.sev_low'); ?>:</strong> <?php _e('bugs.sev_low_desc'); ?>
                    </small>
                </div>

                <div>
                    <h6 class="text-primary">
                        <i class="fas fa-clock me-2"></i><?php _e('bugs.guidelines_response_title'); ?>
                    </h6>
                    <small class="text-muted">
                        <strong><?php _e('bugs.sev_critical'); ?>:</strong> <?php _e('bugs.response_critical'); ?><br>
                        <strong><?php _e('bugs.sev_high'); ?>:</strong> <?php _e('bugs.response_high'); ?><br>
                        <strong><?php _e('bugs.sev_medium'); ?>:</strong> <?php _e('bugs.response_medium'); ?><br>
                        <strong><?php _e('bugs.sev_low'); ?>:</strong> <?php _e('bugs.response_low'); ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
	function formatDateForInput(d) {
		const year = d.getFullYear();
		const month = String(d.getMonth() + 1).padStart(2, '0');
		const day = String(d.getDate()).padStart(2, '0');
		return `${year}-${month}-${day}`;
	}
	function addDays(date, days) {
		const result = new Date(date);
		result.setDate(result.getDate() + days);
		return result;
	}
	function computeDueDate(priority) {
		switch (priority) {
			case 'urgent': return addDays(new Date(), 1); // 24h
			case 'high': return addDays(new Date(), 3);
			case 'medium': return addDays(new Date(), 7);
			case 'low': return addDays(new Date(), 14);
			default: return null;
		}
	}
	function maybeSetDueDate(force) {
		var prioEl = document.getElementById('priority');
		var dueEl = document.getElementById('due_date');
		if (!prioEl || !dueEl) return;
		var prio = prioEl.value;
		var computed = computeDueDate(prio);
		if (computed) {
			if (force || !dueEl.value) {
				dueEl.value = formatDateForInput(computed);
			}
		}
	}
	document.addEventListener('DOMContentLoaded', function() {
		var prioEl = document.getElementById('priority');
		if (prioEl) {
			prioEl.addEventListener('change', function() { maybeSetDueDate(true); });
			// initial autopopulate if priority already chosen and due date empty
			maybeSetDueDate(false);
		}
	});
})();
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>