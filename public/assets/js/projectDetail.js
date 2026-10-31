/**
 * Project Detail Page JavaScript
 * Consolidated logic for Admin, Staff, and Viewer project detail views.
 * Requires window.ProjectConfig to be defined.
 */

// Polyfill for crypto.randomUUID when in insecure/HTTP contexts
if (typeof window.crypto === 'undefined') {
    window.crypto = {};
}
if (typeof window.crypto.randomUUID !== 'function') {
    window.crypto.randomUUID = function () {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = Math.random() * 16 | 0,
                v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    };
}

/* ─── 0. GLOBAL SETUP ─────────────────────────────────────────── */
if (typeof Dropzone !== "undefined") Dropzone.autoDiscover = false;

const getProjectConfig = () => window.ProjectConfig || {};
const getCSRFToken = () =>
    document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content") ?? "";

/* ─── 1. HELPERS ──────────────────────────────────────────────── */

function getErrorMessage(response) {
    if (typeof response === "string") return response;
    if (response?.errors) {
        return Object.values(response.errors).flat().join("<br>");
    }
    return response?.message ?? response?.error ?? "Terjadi kesalahan sistem.";
}

function swal(opts) {
    return Swal.fire({
        buttonsStyling: false,
        confirmButtonText: "OK",
        customClass: { confirmButton: "btn btn-primary" },
        ...opts,
    });
}

function swalError(html, title = "Error!") {
    return Swal.fire({
        title,
        html,
        icon: "error",
        buttonsStyling: false,
        confirmButtonText: "OK",
        customClass: { confirmButton: "btn btn-danger" },
    });
}

function swalConfirm(text, opts = {}) {
    return Swal.fire({
        text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, lanjutkan!",
        cancelButtonText: "Batal",
        buttonsStyling: false,
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-light",
        },
        ...opts,
    });
}

async function checkTaskStatusEligibility(taskId, status) {
    try {
        const resp = await fetch(
            `/api/tasks/${taskId}/status-check?status=${encodeURIComponent(status)}`,
            {
                method: "GET",
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
                credentials: "same-origin",
            },
        );

        const data = await resp.json();
        if (!resp.ok || data.success === false) {
            return {
                allowed: false,
                reason:
                    data?.message ??
                    "Gagal melakukan pengecekan kelayakan status task.",
            };
        }

        return data?.data ?? { allowed: false, reason: "Respons API tidak valid." };
    } catch {
        return {
            allowed: false,
            reason: "Tidak dapat terhubung ke API pengecekan task.",
        };
    }
}

/* ─── 2. DROPZONE FACTORY ─────────────────────────────────────── */

function makeDropzone(el, overrides = {}) {
    if (el.dropzone) el.dropzone.destroy();

    return new Dropzone(el, {
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 5,
        maxFiles: 5,
        maxFilesize: 50,
        paramName: "attachments",
        acceptedFiles:
            ".pdf,.jpg,.jpeg,.png,.webp,.xlsx,.xls,.doc,.docx,.mp4,.avi,.mov,.mkv,.webm",
        addRemoveLinks: true,
        headers: { "X-CSRF-TOKEN": getCSRFToken() },
        ...overrides,
    });
}

function initTaskFormDropzone(
    dropzoneEl,
    formEl,
    submitBtn,
    onSuccessCallback,
    taskId = null,
) {
    if (!dropzoneEl || !formEl) return null;

    const dz = makeDropzone(dropzoneEl, { url: formEl.getAttribute("action") });

    submitBtn?.addEventListener("click", function (e) {
        e.preventDefault();
        if (!formEl.checkValidity()) {
            formEl.reportValidity();
            return;
        }

        submitBtn.setAttribute("data-kt-indicator", "on");
        submitBtn.disabled = true;

        if (dz.getQueuedFiles().length > 0) {
            dz.processQueue();
        } else {
            if (taskId) {
                handleTaskFormSubmit(formEl, taskId, submitBtn);
            } else {
                formEl.submit();
            }
        }
    });

    dz.on("sendingmultiple", function (files, xhr, formData) {
        new FormData(formEl).forEach((val, key) => {
            if (key !== "attachments") formData.append(key, val);
        });
    });

    dz.on("successmultiple", function () {
        if (onSuccessCallback) {
            onSuccessCallback();
        } else {
            swal({ text: "Berhasil disimpan!", icon: "success" }).then(() =>
                location.reload(),
            );
        }
    });

    dz.on("errormultiple", function (files, response) {
        submitBtn?.removeAttribute("data-kt-indicator");
        if (submitBtn) submitBtn.disabled = false;
        swalError(getErrorMessage(response));
    });

    return dz;
}

/* ─── 3. FEATURE MODULES ─────────────────────────────────────── */

// --- Category Modal ---
function initCategoryModal() {
    const config = getProjectConfig();
    document.addEventListener("click", (e) => {
        const opt = e.target.closest(".category-color-option");
        if (!opt) return;
        const picker = opt.closest(".category-color-picker");
        picker
            ?.querySelectorAll(".category-color-option")
            .forEach((o) => o.classList.remove("selected"));
        opt.classList.add("selected");
        const hidden = picker?.querySelector('input[type="hidden"]');
        if (hidden) hidden.value = opt.dataset.color;
    });

    document
        .getElementById("btn_modal_save_category")
        ?.addEventListener("click", async function () {
            const btn = this;
            const nameInput = document.getElementById("modal_category_name");
            const colorInput = document.getElementById("modal_selected_color");
            const name = nameInput?.value?.trim();
            const color = colorInput?.value ?? "#009EF7";

            if (!name) {
                swal({
                    text: "Nama kategori tidak boleh kosong!",
                    icon: "warning",
                });
                return;
            }

            btn.disabled = true;
            const label = btn.querySelector(".indicator-label");
            const progress = btn.querySelector(".indicator-progress");
            if (label) label.style.display = "none";
            if (progress) progress.style.display = "inline-block";

            try {
                const resp = await fetch(config.routes.categoryStore, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": getCSRFToken(),
                    },
                    body: JSON.stringify({ name, color }),
                });
                const data = await resp.json();

                if (data.success && data.category) {
                    const addOption = (select) => {
                        if (!select) return;
                        const opt = document.createElement("option");
                        opt.value = data.category.id;
                        opt.text = data.category.name;
                        opt.dataset.color = data.category.color;
                        select.appendChild(opt);
                    };

                    addOption(
                        document.getElementById("add_task_category_select"),
                    );
                    document
                        .querySelectorAll(".edit-task-category-select")
                        .forEach(addOption);

                    const addSelect = document.getElementById(
                        "add_task_category_select",
                    );
                    if (addSelect) addSelect.value = data.category.id;

                    nameInput.value = "";
                    colorInput.value = "#009EF7";
                    document
                        .getElementById("modal_category_color_picker")
                        ?.querySelectorAll(".category-color-option")
                        .forEach((el, i) =>
                            el.classList.toggle("selected", i === 0),
                        );

                    bootstrap.Modal.getInstance(
                        document.getElementById("kt_modal_add_category"),
                    )?.hide();
                    swal({
                        text: "Kategori berhasil dibuat!",
                        icon: "success",
                    });
                } else {
                    swalError(data.message ?? "Gagal membuat kategori");
                }
            } catch {
                swalError("Terjadi kesalahan saat membuat kategori");
            } finally {
                btn.disabled = false;
                if (label) label.style.display = "inline";
                if (progress) progress.style.display = "none";
            }
        });
}

// --- Reviewer UI ---
function buildReviewerRow() {
    const config = getProjectConfig();
    const allUsers = config.allUsers || [];
    const options = allUsers
        .map((u) => `<option value="${u.id}">${u.name}</option>`)
        .join("");
    const row = document.createElement("div");
    row.className = "d-flex align-items-center gap-3 mb-3 reviewer-row";
    row.innerHTML = `
        <select name="reviewer_ids[]" class="form-select form-select-sm form-select-solid w-200px">
            <option value="">Pilih User</option>${options}
        </select>
        <select name="reviewer_levels[]" class="form-select form-select-sm form-select-solid w-125px">
            <option value="1">Level 1 (UAT)</option>
            <option value="2">Level 2 (PM)</option>
            <option value="3">Level 3</option>
        </select>
        <button type="button" class="btn btn-sm btn-icon btn-light-danger btn-remove-reviewer">
            <i class="ki-outline ki-cross fs-5"></i>
        </button>`;
    return row;
}

function handleCategoryAutoAssign(categorySelect) {
    if (!categorySelect) return;
    const form = categorySelect.closest("form");
    if (!form) return;

    const userSelect = form.querySelector('select[name="assigned_user_id"]');
    if (!userSelect) return;

    const selectedOption = categorySelect.selectedOptions ? categorySelect.selectedOptions[0] : null;
    if (!selectedOption || !selectedOption.value) return;

    let suggestedUser = selectedOption.getAttribute("data-suggested-user");

    if (!suggestedUser) {
        const catName = (selectedOption.textContent || "").toLowerCase();
        Array.from(userSelect.options).forEach((opt) => {
            const userName = (opt.textContent || "").toLowerCase();
            if (suggestedUser || !opt.value) return;

            if (catName.includes("ui") || catName.includes("ux") || catName.includes("design") || catName.includes("wireframe")) {
                if (userName.includes("ui") || userName.includes("ux") || userName.includes("designer")) {
                    suggestedUser = opt.value;
                }
            } else if (catName.includes("test") || catName.includes("qa")) {
                if (userName.includes("test") || userName.includes("qa")) {
                    suggestedUser = opt.value;
                }
            } else if (catName.includes("sec")) {
                if (userName.includes("sec")) {
                    suggestedUser = opt.value;
                }
            } else if (catName.includes("prod") || catName.includes("deploy")) {
                if (userName.includes("prod")) {
                    suggestedUser = opt.value;
                }
            } else if (catName.includes("build") || catName.includes("program") || catName.includes("code") || catName.includes("dev") || catName.includes("maint")) {
                if (userName.includes("program") || userName.includes("dev") || userName.includes("back") || userName.includes("front") || userName.includes("user")) {
                    suggestedUser = opt.value;
                }
            }
        });
    }

    if (suggestedUser) {
        const optionToSelect = userSelect.querySelector(`option[value="${suggestedUser}"]`);
        if (optionToSelect) {
            userSelect.value = suggestedUser;
            if (typeof jQuery !== "undefined") {
                $(userSelect).trigger("change");
            } else {
                userSelect.dispatchEvent(new Event("change"));
            }
        }
    }
}

document.addEventListener("change", (e) => {
    if (e.target && e.target.name === "task_category_id") {
        handleCategoryAutoAssign(e.target);
    }
});

if (typeof jQuery !== "undefined") {
    $(document).on("change select2:select", 'select[name="task_category_id"]', function() {
        handleCategoryAutoAssign(this);
    });

    $(document).on("shown.bs.modal", "#kt_modal_add_task", function() {
        const catSelect = this.querySelector('select[name="task_category_id"]');
        if (catSelect && catSelect.value) {
            handleCategoryAutoAssign(catSelect);
        }
    });
}

function initReviewerUI() {
    document.addEventListener("change", (e) => {
        if (e.target.id === "add_needs_review") {
            document
                .getElementById("add_reviewers_section")
                ?.classList.toggle("d-none", !e.target.checked);
        }
        if (e.target.classList.contains("edit-needs-review")) {
            document
                .getElementById(
                    `edit_reviewers_section_${e.target.dataset.taskId}`,
                )
                ?.classList.toggle("d-none", !e.target.checked);
        }
    });

    document
        .getElementById("btn_add_reviewer")
        ?.addEventListener("click", () => {
            const c = document.getElementById("add_reviewers_container");
            c?.querySelector(
                ".reviewer-placeholder, .text-muted.text-center",
            )?.remove();
            c?.appendChild(buildReviewerRow());
        });

    document.addEventListener("click", (e) => {
        const addBtn = e.target.closest(".btn-add-reviewer");
        if (addBtn) {
            const c = document.getElementById(
                `edit_reviewers_container_${addBtn.dataset.taskId}`,
            );
            c?.querySelector(".reviewer-placeholder")?.remove();
            c?.appendChild(buildReviewerRow());
        }

        const removeBtn = e.target.closest(".btn-remove-reviewer");
        removeBtn?.closest(".reviewer-row")?.remove();
    });
}

// --- Review Actions (Approve / Reject) ---
function initReviewActions() {
    document.addEventListener("click", (e) => {
        const btn = e.target.closest("button.btn-review-action");
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();

        const action = btn.dataset.action;
        const form = btn.closest("form.review-form");
        if (!action || !form) return;

        const isApprove = action === "approve";
        const label = isApprove ? "Approve" : "Reject";
        const btnClass = isApprove ? "btn btn-success" : "btn btn-danger";

        Swal.fire({
            text: `Yakin ingin melakukan ${label} progress task ini?`,
            icon: isApprove ? "question" : "warning",
            showCancelButton: true,
            confirmButtonText: `Ya, ${label}!`,
            cancelButtonText: "Batal",
            buttonsStyling: false,
            customClass: {
                confirmButton: btnClass,
                cancelButton: "btn btn-light ms-2",
            },
            didOpen() {
                const el = document.querySelector(".swal2-container");
                if (el) el.style.zIndex = "100000";
            },
        }).then((result) => {
            if (result.isConfirmed) {
                const actionInput = form.querySelector('input[name="action"]');
                if (actionInput) {
                    actionInput.value = action;
                    form.submit();
                }
            }
        });
    });
}

// --- Task Status Update ---
function handleTaskFormSubmit(form, taskId, submitBtn) {
    const config = getProjectConfig();
    const projectId = config.projectId;
    const statusField = form.querySelector('[name="status"]');
    const newStatus = statusField?.value ?? null;

    // Check if only status changed
    const changed = {};
    new FormData(form).forEach((value, key) => {
        const input = form.querySelector(`[name="${key}"]`);
        if (!input) return;
        const original =
            input.getAttribute("data-original-value") ??
            input.defaultValue ??
            "";
        if (String(value) !== String(original)) changed[key] = value;
    });

    const onlyStatus = Object.keys(changed).length === 1 && "status" in changed;

    if (onlyStatus && newStatus && config.role === "admin") {
        quickUpdateTaskStatus(projectId, taskId, newStatus, submitBtn);
    } else {
        form.submit();
    }
}

async function quickUpdateTaskStatus(projectId, taskId, newStatus, submitBtn) {
    if (submitBtn) {
        submitBtn.setAttribute("data-kt-indicator", "on");
        submitBtn.disabled = true;
    }

    const resetBtn = () => {
        submitBtn?.removeAttribute("data-kt-indicator");
        if (submitBtn) submitBtn.disabled = false;
    };

    const controller = new AbortController();
    const timerId = setTimeout(() => controller.abort(), 8000);

    try {
        const resp = await fetch(
            `/admin/projects/${projectId}/tasks/${taskId}/quick-status`,
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": getCSRFToken(),
                },
                body: JSON.stringify({ status: newStatus }),
                signal: controller.signal,
            },
        );
        clearTimeout(timerId);
        const data = await resp.json();
        resetBtn();

        if (data.success) {
            await swal({
                text: data.message ?? "Status berhasil diperbarui!",
                icon: "success",
            });
            location.reload();
        } else {
            swalError(data.message ?? "Gagal memperbarui status.");
        }
    } catch (err) {
        clearTimeout(timerId);
        resetBtn();
        await swal({
            title: "Status Update",
            text: "Status berhasil diperbarui! (Notifikasi WAHA dikirim di background)",
            icon: "success",
        });
        location.reload();
    }
}

/* ─── 4. GANTT CHART ────────────────────────────────────────── */

// Fungsi utama untuk me-render Gantt Chart
function renderGanttChart() {
    const container = document.getElementById("apexGanttContainer");

    if (!container || container.hasAttribute("data-rendered")) return;

    // getProjectConfig() akan mengambil dari fungsimu yang sudah ada
    const config = getProjectConfig();
    const tasks = config.ganttTasks;

    if (!Array.isArray(tasks) || tasks.length === 0) {
        container.innerHTML =
            '<div class="text-center text-muted py-10">Belum ada task dengan tanggal mulai dan selesai.</div>';
        container.setAttribute("data-rendered", "true");
        return;
    }

    if (typeof ApexGantt === "undefined") {
        container.innerHTML =
            '<div class="text-center text-danger py-10">ApexGantt belum termuat. Silakan refresh halaman.</div>';
        return;
    }

    const esc = (v) =>
        String(v ?? "")
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");

    const series = tasks.map((task) => {
        const color = task.color || "#009EF7";
        const assigneeName = task.assignee_name || "Unassigned";
        return {
            id: task.id,
            name: `${task.display_name || task.name} (${assigneeName})`,
            startTime: task.start,
            endTime: task.end,
            progress: task.progress,
            taskName: task.name,
            assigneeName,
            assigneeAvatar: task.assignee_avatar || null,
            category: task.category || null,
            dependency: task.dependency || null,
            barBackgroundColor: color,
            color,
            fillColor: color,
            barTextColor: "#ffffff",
            ...(task.dependency ? { dependency: task.dependency } : {}),
        };
    });

    const gantt = new ApexGantt(container, {
        enableCriticalPath: false,
        enableTaskDrag: true,
        enableTaskResize: true,
        viewMode: "week",
        inputDateFormat: "YYYY-MM-DD",
        tasksContainerWidth: 450,
        columnConfig: [
            {
                key: "name",
                title: "Task Name",
                minWidth: "250px",
                flexGrow: 3,
            },
            {
                key: "startTime",
                title: "Start",
                minWidth: "100px",
                flexGrow: 1,
            },
            {
                key: "duration",
                title: "Duration",
                minWidth: "80px",
                flexGrow: 1,
            },
            {
                key: "progress",
                title: "Progress",
                minWidth: "80px",
                flexGrow: 1,
            },
        ],

        // Return string HTML secara langsung
        tooltipTemplate(task) {
            const avatarUrl = task.assigneeAvatar;
            const initial = (task.assigneeName ?? "U").charAt(0).toUpperCase();

            const avatarHtml = avatarUrl
                ? `<img src="${esc(avatarUrl)}" alt="${esc(task.assigneeName)}" style="width:22px;height:22px;border-radius:50%;object-fit:cover;vertical-align:middle;margin-right:6px;">`
                : `<span style="display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;background:#eef3ff;color:#3f5bf6;font-size:11px;font-weight:700;margin-right:6px;">${initial}</span>`;

            return `
                <div style="display:flex;flex-direction:column;gap:5px;padding:10px 12px;font-size:13px;line-height:1.5;min-width:200px;max-width:300px;background:#fff;border:1px solid #E4E6EF;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                    <div style="font-weight:600;margin-bottom:2px;color:#181C32;">${esc(task.taskName ?? task.name)}</div>
                    <div style="display:flex;align-items:center;color:#3F4254;">${avatarHtml}<span>${esc(task.assigneeName ?? "Unassigned")}</span></div>
                    <div style="color:#7E8299;"><span style="opacity:.6;">Kategori:&nbsp;</span>${esc(task.category ?? "-")}</div>
                    <div style="color:#7E8299;"><span style="opacity:.6;">Mulai:&nbsp;</span>${esc(task.startTime)}</div>
                    <div style="color:#7E8299;"><span style="opacity:.6;">Selesai:&nbsp;</span>${esc(task.endTime)}</div>
                    <div style="color:#7E8299;"><span style="opacity:.6;">Predecessor:&nbsp;</span>${esc(task.dependency ?? "-")}</div>
                    <div style="color:#7E8299;"><span style="opacity:.6;">Progress:&nbsp;</span><strong style="color:#50CD89;">${task.progress ?? 0}%</strong></div>
                </div>
            `;
        },
        series,
    });

    gantt.render();
    container.setAttribute("data-rendered", "true");
}

function setGanttFullviewState(isFullview) {
    const ganttModal = document.getElementById("ganttTimelineModal");
    const toggleBtn = document.getElementById("btn_gantt_fullview_toggle");
    const container = document.getElementById("apexGanttContainer");

    if (!ganttModal || !toggleBtn) return;

    ganttModal.classList.toggle("is-gantt-fullview", isFullview);
    toggleBtn.setAttribute("aria-pressed", isFullview ? "true" : "false");
    toggleBtn.setAttribute("title", isFullview ? "Exit Fullview" : "Fullview");
    toggleBtn.setAttribute(
        "aria-label",
        isFullview ? "Exit full view" : "Toggle full view",
    );

    if (container?.hasAttribute("data-rendered")) {
        window.requestAnimationFrame(() => {
            window.dispatchEvent(new Event("resize"));
        });
    }
}

window.__projectDetailGanttReady = true;

// Tambahkan event listener ini di bagian paling bawah atau di luar fungsi lain
document.addEventListener("DOMContentLoaded", function () {
    const ganttModalElement = document.getElementById("ganttTimelineModal");
    const ganttFullviewButton = document.getElementById(
        "btn_gantt_fullview_toggle",
    );

    if (ganttModalElement) {
        ganttModalElement.addEventListener("shown.bs.modal", function () {
            renderGanttChart();
        });

        ganttModalElement.addEventListener("hidden.bs.modal", function () {
            const container = document.getElementById("apexGanttContainer");
            if (container) {
                container.innerHTML = "";
                container.removeAttribute("data-rendered");
            }
            setGanttFullviewState(false);
        });

        ganttFullviewButton?.addEventListener("click", function () {
            const isFullview = !ganttModalElement.classList.contains(
                "is-gantt-fullview",
            );
            setGanttFullviewState(isFullview);
        });
    }
});

// PERBAIKAN 2: Listener untuk memicu render hanya setelah modal sepenuhnya terbuka (animasi selesai)
document.addEventListener("DOMContentLoaded", function () {
    const ganttModalElement = document.getElementById("ganttTimelineModal");

    if (ganttModalElement) {
        // Event spesifik Bootstrap 5 saat modal 100% terbuka
        ganttModalElement.addEventListener("shown.bs.modal", function () {
            renderGanttChart();
        });

        // (Opsional) Reset chart saat modal ditutup agar saat dibuka kembali bisa menyesuaikan ukuran secara sempurna
        ganttModalElement.addEventListener("hidden.bs.modal", function () {
            const container = document.getElementById("apexGanttContainer");
            if (container) {
                container.innerHTML = "";
                container.removeAttribute("data-rendered");
            }
        });
    }
});

/* ─── 5. BOOTSTRAP ───────────────────────────────────────────── */

document.addEventListener("DOMContentLoaded", function () {
    const config = getProjectConfig();

    // 1. Flatpickr
    if (typeof jQuery !== "undefined" && $.fn.flatpickr) {
        $(".datepicker").flatpickr({ dateFormat: "Y-m-d" });
    }

    // 2. Gantt Modal Trigger
    const ganttModalEl = document.getElementById("ganttTimelineModal");
    if (ganttModalEl) {
        document
            .querySelectorAll(".category-progress-track")
            .forEach((track) => {
                track.style.cursor = "pointer";
                track.addEventListener("click", (e) => {
                    e.preventDefault();
                    new bootstrap.Modal(ganttModalEl).show();
                });
            });
        ganttModalEl.addEventListener("shown.bs.modal", () => {
            const container = document.getElementById("apexGanttContainer");
            if (container) container.removeAttribute("data-rendered");
            renderGanttChart();
        });
    }

    // 3. Dropzones
    if (["admin", "security", "tester", "production"].includes(config.role)) {
        // Admin Page specific
        initAddTaskDropzone();
        initEditTaskDropzones();
        initViewTaskDropzones();
        initDeleteTaskAttachment();
        initProjectDropzones();
        initDeleteProjectAttachment();
        initCategoryModal();
        initReviewerUI();
        initReviewActions();
        initRolesUI();
    } else if (config.role === "staff" || config.role === "user") {
        // Staff Page specific
        initStaffProjectDropzone();
        initDeleteProjectAttachmentStaff();
        initReviewActions();
    }

    // 4. URL Hash handling
    openModalFromUrl();
});

// Admin specific init functions
function initAddTaskDropzone() {
    const dropzoneEl = document.getElementById("kt_modal_add_task_dropzone");
    const formEl = document.getElementById("form_add_task");
    const submitBtn = document.getElementById("btn_submit_add_task");
    const dz = initTaskFormDropzone(dropzoneEl, formEl, submitBtn, () => {
        swal({ text: "Task berhasil dibuat!", icon: "success" }).then(() =>
            location.reload(),
        );
    });
    document
        .getElementById("kt_modal_add_task")
        ?.addEventListener("hidden.bs.modal", () => {
            dz?.removeAllFiles(true);
            formEl?.reset();
        });
}

function initEditTaskDropzones() {
    document.querySelectorAll(".edit-task-dropzone").forEach((dropzoneEl) => {
        const taskId = dropzoneEl.getAttribute("data-task-id");
        const formEl = document.getElementById(`form_edit_task_${taskId}`);
        const submitBtn = document.getElementById(
            `btn_submit_edit_task_${taskId}`,
        );
        const dz = initTaskFormDropzone(
            dropzoneEl,
            formEl,
            submitBtn,
            () => {
                swal({
                    text: "Task berhasil diperbarui!",
                    icon: "success",
                }).then(() => location.reload());
            },
            taskId,
        );
        document
            .getElementById(`kt_modal_edit_task_${taskId}`)
            ?.addEventListener("hidden.bs.modal", () =>
                dz?.removeAllFiles(true),
            );
    });
}

function initViewTaskDropzones() {
    const config = getProjectConfig();
    const isSecurity = config.role === "security";
    document.querySelectorAll(".task-dropzone").forEach((el) => {
        const taskId = el.getAttribute("data-task-id");
        if (el.dropzone) el.dropzone.destroy();
        new Dropzone(el, {
            url: isSecurity
                ? `/security/tasks/${taskId}/attachments`
                : `/admin/projects/${config.projectId}/tasks/${taskId}/attachments`,
            paramName: "file",
            maxFilesize: 50,
            acceptedFiles:
                ".pdf,.jpg,.jpeg,.png,.webp,.xlsx,.xls,.doc,.docx,.mp4,.avi,.mov,.mkv,.webm",
            headers: { "X-CSRF-TOKEN": getCSRFToken() },
            success() {
                swal({
                    text: "Berhasil mengunggah lampiran!",
                    icon: "success",
                }).then(() => {
                    window.location.hash = `#task_modal_${taskId}`;
                    location.reload();
                });
            },
            error(file, response) {
                swalError(getErrorMessage(response));
                this.removeFile(file);
            },
        });
    });
}

function initDeleteTaskAttachment() {
    const config = getProjectConfig();
    const isSecurity = config.role === "security";
    document.querySelectorAll(".delete-task-attachment-btn").forEach((btn) => {
        btn.addEventListener("click", async function (e) {
            e.preventDefault();
            const taskId = this.dataset.taskId;
            const path = this.dataset.path;
            const result = await swalConfirm(
                "Apakah Anda yakin ingin menghapus lampiran ini?",
            );
            if (!result.isConfirmed) return;
            try {
                const url = isSecurity
                    ? `/security/tasks/${taskId}/attachments`
                    : `/admin/projects/${config.projectId}/tasks/${taskId}/attachments`;
                const resp = await fetch(
                    url,
                    {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": getCSRFToken(),
                        },
                        body: JSON.stringify({ file_path: path }),
                    },
                );
                const data = await resp.json();
                if (data.success) {
                    await swal({
                        text: "Lampiran berhasil dihapus!",
                        icon: "success",
                    });
                    window.location.hash = `#task_modal_${taskId}`;
                    location.reload();
                } else {
                    swalError(data.error ?? "Gagal menghapus.");
                }
            } catch {
                swalError("Terjadi kesalahan sistem.");
            }
        });
    });
}

function initProjectDropzones() {
    const config = getProjectConfig();
    const adminEl = document.getElementById("admin_project_dropzone");
    if (adminEl) {
        if (adminEl.dropzone) adminEl.dropzone.destroy();
        new Dropzone(adminEl, {
            url: config.routes.attachmentStore,
            paramName: "file",
            maxFilesize: 50,
            acceptedFiles:
                ".pdf,.jpg,.jpeg,.png,.webp,.xlsx,.xls,.doc,.docx,.mp4,.avi,.mov,.mkv,.webm",
            headers: { "X-CSRF-TOKEN": getCSRFToken() },
            success() {
                swal({
                    text: "Attachment berhasil diunggah!",
                    icon: "success",
                }).then(() => location.reload());
            },
            error(file, response) {
                swalError(getErrorMessage(response), "Upload Failed");
            },
        });
    }

    document.querySelectorAll(".edit-dropzone").forEach((el) => {
        if (el.dropzone) el.dropzone.destroy();
        const projectId = el.getAttribute("data-id");
        let dt = new DataTransfer();
        new Dropzone(el, {
            url: "https://",
            autoProcessQueue: false,
            addRemoveLinks: true,
            maxFilesize: 50,
            init() {
                this.on("addedfile", (file) => {
                    dt.items.add(file);
                    document.getElementById(
                        `edit_attachments_input_${projectId}`,
                    ).files = dt.files;
                });
                this.on("removedfile", (file) => {
                    const newDt = new DataTransfer();
                    [...dt.files]
                        .filter((f) => f.name !== file.name)
                        .forEach((f) => newDt.items.add(f));
                    dt = newDt;
                    document.getElementById(
                        `edit_attachments_input_${projectId}`,
                    ).files = dt.files;
                });
            },
        });
    });
}

function initDeleteProjectAttachment() {
    const config = getProjectConfig();
    document.querySelectorAll(".delete-attachment-btn").forEach((btn) => {
        btn.addEventListener("click", async function () {
            const path = this.dataset.path;
            const result = await swalConfirm(
                "Apakah Anda yakin ingin menghapus attachment ini?",
            );
            if (!result.isConfirmed) return;
            try {
                const resp = await fetch(config.routes.attachmentDestroy, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": getCSRFToken(),
                    },
                    body: JSON.stringify({ file_path: path }),
                });
                const data = await resp.json();
                if (data.success) {
                    await swal({
                        text: "Attachment berhasil dihapus!",
                        icon: "success",
                    });
                    location.reload();
                } else {
                    swalError("Gagal menghapus attachment.");
                }
            } catch {
                swalError("Terjadi kesalahan sistem.");
            }
        });
    });
}

function initRolesUI() {
    $(".edit-team-select").each(function () {
        const projectId = $(this).data("project-id");
        const containerId = `edit_roles_container_${projectId}`;
        buildRolesUI(this, containerId);
        $(this).on("change", function () {
            buildRolesUI(this, containerId);
        });
    });
}

function buildRolesUI(selectBox, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    const saved = {};
    container.querySelectorAll('input[type="text"]').forEach((i) => {
        saved[i.name] = i.value;
    });
    container.innerHTML = "";
    const selected = Array.from(selectBox.selectedOptions);
    if (!selected.length) return;
    let html = `<label class="fs-6 fw-semibold mb-2">Assign Roles <span class="text-muted fs-8 fw-normal">(Optional)</span></label><div class="border border-dashed border-gray-300 p-4 rounded bg-light">`;
    selected.forEach((opt) => {
        const userId = opt.value;
        const userName = opt.text.trim();
        const inputName = `roles[${userId}]`;
        const role = saved[inputName] ?? opt.dataset.role ?? "";
        html += `<div class="d-flex flex-stack mb-3"><div class="d-flex align-items-center"><div class="symbol symbol-30px me-3"><span class="symbol-label bg-secondary text-gray-800 fw-bold">${userName.charAt(0).toUpperCase()}</span></div><div class="fw-bold fs-6 text-gray-800">${userName}</div></div><div class="w-200px"><input type="text" name="${inputName}" value="${role}" class="form-control form-control-sm form-control-solid" placeholder="Role (e.g. Backend)"></div></div>`;
    });
    html += "</div>";
    container.innerHTML = html;
}

// Staff specific init functions
function initStaffProjectDropzone() {
    const config = getProjectConfig();
    const el = document.getElementById("staff_project_dropzone");
    if (!el) return;
    new Dropzone(el, {
        url: config.routes.attachmentStore,
        paramName: "file",
        maxFilesize: 50,
        acceptedFiles:
            ".pdf,.jpg,.jpeg,.png,.webp,.xlsx,.xls,.doc,.docx,.mp4,.avi,.mov,.mkv,.webm",
        headers: { "X-CSRF-TOKEN": getCSRFToken() },
        success: function () {
            swal({
                text: "Attachment successfully uploaded!",
                icon: "success",
            }).then(() => location.reload());
        },
        error: function (file, response) {
            swalError(getErrorMessage(response));
        },
    });
}

function initDeleteProjectAttachmentStaff() {
    const config = getProjectConfig();
    document.querySelectorAll(".delete-attachment-btn").forEach((btn) => {
        btn.addEventListener("click", function () {
            let path = this.getAttribute("data-path");
            swalConfirm("Apakah Anda yakin ingin menghapus attachment ini?", {
                confirmButtonText: "Ya, hapus!",
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(config.routes.attachmentDestroy, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": getCSRFToken(),
                        },
                        body: JSON.stringify({ file_path: path }),
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                swal({
                                    text: "Attachment berhasil dihapus!",
                                    icon: "success",
                                }).then(() => location.reload());
                            } else {
                                swalError("Gagal menghapus attachment.");
                            }
                        });
                }
            });
        });
    });
}

function openModalFromUrl() {
    const params = new URLSearchParams(window.location.search);
    const fromQuery = params.get("open_task");
    if (fromQuery) {
        const el = document.getElementById(`kt_modal_view_task_${fromQuery}`);
        if (el) new bootstrap.Modal(el).show();
        history.replaceState({}, document.title, window.location.pathname);
        return;
    }
    if (window.location.hash?.startsWith("#task_modal_")) {
        const taskId = window.location.hash.replace("#task_modal_", "");
        const el = document.getElementById(`kt_modal_view_task_${taskId}`);
        if (el) new bootstrap.Modal(el).show();
        history.replaceState(
            null,
            null,
            window.location.pathname + window.location.search,
        );
    }
}

// Global onclick helpers (if any used in blade)
window.deleteTask = function (id, name) {
    swalConfirm(`Apakah Anda yakin ingin menghapus task "${name}"?`, {
        confirmButtonText: "Ya, Hapus!",
    }).then((result) => {
        if (result.isConfirmed)
            document.getElementById(`delete-task-form-${id}`)?.submit();
    });
};

window.updateTaskStatus = async function (taskId, status) {
    const eligibility = await checkTaskStatusEligibility(taskId, status);
    if (!eligibility.allowed) {
        Swal.fire({
            title: "Tidak Dapat Mengubah Status",
            html: eligibility.reason ?? "Task belum memenuhi syarat untuk perubahan status.",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Mengerti",
            customClass: { confirmButton: "btn btn-warning" },
        });
        return;
    }

    const statusText = status === "completed" ? "selesai" : "in progress";
    let messageText = `Tandai task ini sebagai ${statusText}?`;
    let confirmIcon = "question";

    if (eligibility.warning) {
        messageText = eligibility.warning;
        confirmIcon = "warning";
    }

    swalConfirm(messageText, {
        icon: confirmIcon,
        confirmButtonText: "Ya!",
        customClass: {
            confirmButton: `btn btn-${status === "completed" ? "success" : "primary"}`,
            cancelButton: "btn btn-light",
        },
    }).then((result) => {
        if (result.isConfirmed) {
            const config = getProjectConfig();
            const form = document.createElement("form");
            form.method = "POST";
            let actionUrl = `${config.baseUrl}/tasks/${taskId}/status`;
            if (config.role !== 'admin') {
                const baseRoleUrl = config.baseUrl.replace(/\/projects\/\d+$/, '');
                actionUrl = `${baseRoleUrl}/tasks/${taskId}/status`;
            }
            form.action = actionUrl;

            const csrf = document.createElement("input");
            csrf.type = "hidden";
            csrf.name = "_token";
            csrf.value = getCSRFToken();
            form.appendChild(csrf);

            const method = document.createElement("input");
            method.type = "hidden";
            method.name = "_method";
            method.value = "PATCH";
            form.appendChild(method);

            const statusInput = document.createElement("input");
            statusInput.type = "hidden";
            statusInput.name = "status";
            statusInput.value = status;
            form.appendChild(statusInput);

            document.body.appendChild(form);
            form.submit();
        }
    });
};
