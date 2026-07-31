<?php
// View: app/Views/examinations/index.php
// Lists examinations and provides actions to create, edit and delete.
?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Examinations</h1>
        <a href="/examination/create" class="btn btn-primary">New Examination</a>
    </div>

    <?php if (empty($examinations)): ?>
        <div class="alert alert-info">No examinations found.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Academic Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($examinations as $exam): ?>
                        <tr>
                            <td><?= htmlspecialchars($exam['id'] ?? '') ?></td>
                            <td><?= htmlspecialchars($exam['title'] ?? $exam['exam_name'] ?? '') ?></td>
                            <td>
                                <?php if (!empty($exam['date'])): ?>
                                    <?= htmlspecialchars((new DateTime($exam['date']))->format('Y-m-d')) ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($exam['academic_year_id'] ?? '-') ?>
                            </td>
                            <td>
                                <a href="/examination/edit/<?= htmlspecialchars($exam['id'] ?? '') ?>" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                                <a href="/examination/delete/<?= htmlspecialchars($exam['id'] ?? '') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this examination?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
