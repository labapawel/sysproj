@php
    $boardDomId = 'student-board-' . $board['enrollment']['id'];
@endphp
<div id="{{ $boardDomId }}" class="student-board" data-student-board data-board="{{ json_encode($board) }}">
    <style>
        .student-board {
            --sb-surface: #ffffff;
            --sb-surface-muted: #f8fafc;
            --sb-border: #e2e8f0;
            --sb-text: #0f172a;
            --sb-text-muted: #475569;
            --sb-accent: #4f46e5;
            --sb-accent-muted: rgba(79, 70, 229, 0.15);
            --sb-card-bg: #ffffff;
            --sb-column-bg: #f8fafc;
            --sb-column-border: #e2e8f0;
            --sb-shadow: 0 15px 40px rgba(15, 23, 42, 0.1);
            --sb-task-bg: #ffffff;
            --sb-task-border: #e2e8f0;
            --sb-task-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            --sb-hint-bg: #f8fafc;
            --sb-hint-border: #e2e8f0;
            --sb-badge-bg: rgba(148, 163, 184, 0.15);
            --sb-badge-text: #475569;
            --sb-success: #16a34a;
            --sb-danger: #dc2626;
            --sb-scrollbar: rgba(148, 163, 184, 0.5);
            border-radius: 1.5rem;
            border: 1px solid var(--sb-border);
            background: var(--sb-surface);
            padding: 1.75rem;
            box-shadow: var(--sb-shadow);
            color: var(--sb-text);
            font-family: var(--font-family, 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif);
        }

        .student-board[data-theme="dark"] {
            --sb-surface: #0f172a;
            --sb-surface-muted: #111c32;
            --sb-border: rgba(148, 163, 184, 0.35);
            --sb-text: #f8fafc;
            --sb-text-muted: #cbd5f5;
            --sb-card-bg: #111c32;
            --sb-column-bg: #16223a;
            --sb-column-border: rgba(148, 163, 184, 0.25);
            --sb-task-bg: #192641;
            --sb-task-border: rgba(148, 163, 184, 0.25);
            --sb-task-shadow: 0 25px 45px rgba(2, 6, 23, 0.7);
            --sb-hint-bg: rgba(79, 70, 229, 0.08);
            --sb-hint-border: rgba(99, 102, 241, 0.3);
            --sb-badge-bg: rgba(99, 102, 241, 0.15);
            --sb-badge-text: #c3dafe;
            --sb-shadow: 0 25px 65px rgba(2, 6, 23, 0.65);
            --sb-scrollbar: rgba(99, 102, 241, 0.4);
        }

        .student-board * {
            box-sizing: border-box;
        }

        body[data-student-board-modal-open='1'] {
            overflow: hidden;
        }

        .student-board__intro {
            display: flex;
            flex-wrap: wrap;
            gap: 1.25rem;
            align-items: flex-end;
            margin-bottom: 1.5rem;
        }

        .student-board__project {
            flex: 1;
        }

        .student-board__project h2 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 600;
        }

        .student-board__project p {
            margin: 0.35rem 0 0;
            color: var(--sb-text-muted);
            font-size: 0.95rem;
        }

        .student-board__selector {
            min-width: 220px;
        }

        .student-board__selector label {
            font-size: 0.85rem;
            color: var(--sb-text-muted);
            display: block;
            margin-bottom: 0.25rem;
        }

        .student-board__selector select {
            width: 100%;
            border-radius: 0.75rem;
            border: 1px solid var(--sb-border);
            background: var(--sb-column-bg);
            color: inherit;
            padding: 0.65rem 0.75rem;
            font-size: 0.95rem;
        }

        .student-board__stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .student-board__stat {
            border-radius: 1rem;
            background: var(--sb-card-bg);
            border: 1px solid var(--sb-border);
            padding: 1rem 1.25rem;
        }

        .student-board__stat p {
            margin: 0;
            color: var(--sb-text-muted);
            font-size: 0.85rem;
        }

        .student-board__stat strong {
            display: block;
            font-size: 1.8rem;
            margin-top: 0.45rem;
        }

        .student-board__stat span {
            color: var(--sb-text-muted);
            font-size: 0.85rem;
        }

        .student-board__pills {
            display: flex;
            gap: 0.5rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
            scrollbar-width: thin;
        }

        .student-board__pills::-webkit-scrollbar {
            height: 6px;
        }

        .student-board__pills::-webkit-scrollbar-thumb {
            background: var(--sb-scrollbar);
            border-radius: 999px;
        }

        .student-board__pill {
            border-radius: 999px;
            padding: 0.35rem 0.95rem;
            border: 1px solid var(--sb-border);
            background: var(--sb-column-bg);
            color: var(--sb-text-muted);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .student-board__pill.is-active {
            background: var(--sb-accent-muted);
            border-color: var(--sb-accent);
            color: var(--sb-text);
        }

        .student-board__pill.is-locked {
            opacity: 0.55;
        }

        .student-board__stage-card {
            border-radius: 1.25rem;
            background: var(--sb-card-bg);
            border: 1px solid var(--sb-border);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .student-board__stage-header {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: space-between;
            align-items: center;
        }

        .student-board__stage-header h3 {
            margin: 0;
            font-size: 1.35rem;
        }

        .student-board__stage-meta {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .student-board__stage-description {
            margin: 1rem 0 0;
            color: var(--sb-text-muted);
            line-height: 1.45;
            font-size: 0.95rem;
        }

        .status-pill {
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            background: var(--sb-badge-bg);
            color: var(--sb-badge-text);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .student-board__columns {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1rem;
        }

        .student-board__column {
            border-radius: 1.25rem;
            border: 1px solid var(--sb-column-border);
            background: var(--sb-column-bg);
            padding: 1rem;
            min-height: 320px;
            display: flex;
            flex-direction: column;
        }

        .student-board__column header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            color: var(--sb-text-muted);
            font-weight: 600;
        }

        .student-board__column-count {
            border-radius: 999px;
            padding: 0.15rem 0.6rem;
            font-size: 0.75rem;
            background: var(--sb-badge-bg);
            color: var(--sb-badge-text);
        }

        .student-board__tasks {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            border-radius: 1rem;
            border: 1px dashed transparent;
            padding: 0.5rem;
            min-height: 240px;
        }

        .student-board__tasks.is-hover {
            border-color: var(--sb-accent);
            background: rgba(79, 70, 229, 0.07);
        }

        .student-board__task {
            border-radius: 1rem;
            border: 1px solid var(--sb-task-border);
            background: var(--sb-task-bg);
            padding: 0.85rem;
            box-shadow: var(--sb-task-shadow);
            cursor: grab;
        }

        .student-board__task.is-dragging {
            opacity: 0.5;
        }

        .student-board__task h4 {
            margin: 0 0 0.35rem;
            font-size: 1rem;
        }

        .student-board__task-meta {
            display: flex;
            justify-content: space-between;
            color: var(--sb-text-muted);
            font-size: 0.8rem;
        }

        .student-board__task-actions {
            margin-top: 0.65rem;
            display: flex;
            justify-content: flex-end;
        }

        .student-board__task-button {
            border: none;
            border-radius: 999px;
            padding: 0.3rem 0.8rem;
            background: var(--sb-accent-muted);
            color: var(--sb-accent);
            font-weight: 600;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .student-board__hint {
            margin-top: 1.75rem;
            border-radius: 1rem;
            padding: 0.9rem 1rem;
            background: var(--sb-hint-bg);
            border: 1px solid var(--sb-hint-border);
            color: var(--sb-text-muted);
        }

        .student-board__message {
            margin-top: 1rem;
            border-radius: 0.85rem;
            padding: 0.75rem 1rem;
            font-weight: 600;
            display: none;
        }

        .student-board__message[data-state="success"] {
            background: rgba(34, 197, 94, 0.15);
            color: var(--sb-success);
            display: block;
        }

        .student-board__message[data-state="error"] {
            background: rgba(248, 113, 113, 0.15);
            color: var(--sb-danger);
            display: block;
        }

        .student-board__message[data-state="info"] {
            background: rgba(79, 70, 229, 0.12);
            color: var(--sb-accent);
            display: block;
        }

        .student-board__lock {
            margin: 0.75rem 0 0;
            color: var(--sb-danger);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .student-board__empty {
            margin-top: 1rem;
            color: var(--sb-text-muted);
            font-style: italic;
        }

        .student-board__modal[hidden] {
            display: none;
        }

        .student-board__modal {
            position: fixed;
            inset: 0;
            z-index: 60;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .student-board__modal::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(8px);
        }

        .student-board__modal-panel {
            position: relative;
            background: var(--sb-task-bg);
            border-radius: 1.25rem;
            border: 1px solid var(--sb-border);
            padding: 1.5rem;
            width: min(480px, 92vw);
            z-index: 1;
            box-shadow: var(--sb-shadow);
        }

        .student-board__modal-panel header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .student-board__modal-panel h4 {
            margin: 0;
            font-size: 1.2rem;
        }

        .student-board__modal-close {
            border: none;
            background: transparent;
            color: var(--sb-text-muted);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .student-board__modal-details {
            display: grid;
            gap: 0.85rem;
        }

        .student-board__modal-details dt {
            font-size: 0.85rem;
            color: var(--sb-text-muted);
            margin-bottom: 0.2rem;
        }

        .student-board__modal-details dd {
            margin: 0;
            font-size: 0.95rem;
            line-height: 1.4;
        }

            .student-board__modal-select {
                width: 100%;
                border-radius: 0.75rem;
                border: 1px solid var(--sb-border);
                background-color: var(--sb-column-bg);
                color: inherit;
                padding: 0.6rem 2.5rem 0.6rem 1rem;
                font-size: 0.95rem;
                appearance: none;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
                background-position: right 0.75rem center;
                background-repeat: no-repeat;
                background-size: 1.25em 1.25em;
                transition: all 0.2s ease-in-out;
                cursor: pointer;
            }

            .student-board__modal-select:hover {
                border-color: var(--sb-accent);
            }

            .student-board__modal-select:focus {
                outline: none;
                border-color: var(--sb-accent);
                box-shadow: 0 0 0 2px var(--sb-accent-muted);
            }

            .student-board__modal-header-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .student-board__modal-header-row h4 {
                margin: 0;
                flex: 1;
            }

            .student-board__modal-header-row .student-board__modal-select {
                min-width: 150px;
                width: auto;
            }

            .student-board__modal-description {
                line-height: 1.6;
            }

            .student-board__modal-description h1,
            .student-board__modal-description h2,
            .student-board__modal-description h3,
            .student-board__modal-description h4,
            .student-board__modal-description h5,
            .student-board__modal-description h6 {
                margin: 1.25em 0 0.5em;
                font-weight: 600;
                line-height: 1.3;
            }

            .student-board__modal-description h1:first-child,
            .student-board__modal-description h2:first-child,
            .student-board__modal-description h3:first-child,
            .student-board__modal-description h4:first-child,
            .student-board__modal-description h5:first-child,
            .student-board__modal-description h6:first-child {
                margin-top: 0;
            }

            .student-board__modal-description h1 { font-size: 1.75em; }
            .student-board__modal-description h2 { font-size: 1.5em; }
            .student-board__modal-description h3 { font-size: 1.25em; }
            .student-board__modal-description h4 { font-size: 1.1em; }
            .student-board__modal-description h5 { font-size: 1em; }
            .student-board__modal-description h6 { font-size: 0.95em; }

            .student-board__modal-description p {
                margin: 0.75em 0;
            }

            .student-board__modal-description ul,
            .student-board__modal-description ol {
                margin: 0.75em 0;
                padding-left: 2em;
            }

            .student-board__modal-description li {
                margin: 0.25em 0;
            }

            .student-board__modal-description code {
                background: var(--sb-column-bg);
                border: 1px solid var(--sb-border);
                border-radius: 0.25rem;
                padding: 0.125rem 0.375rem;
                font-family: 'Courier New', Courier, monospace;
                font-size: 0.9em;
            }

            .student-board__modal-description pre {
                background: var(--sb-column-bg);
                border: 1px solid var(--sb-border);
                border-radius: 0.5rem;
                padding: 1rem;
                overflow-x: auto;
                margin: 1em 0;
            }

            .student-board__modal-description pre code {
                background: none;
                border: none;
                padding: 0;
            }

            .student-board__modal-description blockquote {
                border-left: 3px solid var(--sb-accent);
                padding-left: 1rem;
                margin: 1em 0;
                color: var(--sb-text-muted);
                font-style: italic;
            }

            .student-board__modal-description table {
                width: 100%;
                border-collapse: collapse;
                margin: 1em 0;
            }

            .student-board__modal-description table th,
            .student-board__modal-description table td {
                border: 1px solid var(--sb-border);
                padding: 0.5rem;
                text-align: left;
            }

            .student-board__modal-description table th {
                background: var(--sb-column-bg);
                font-weight: 600;
            }

            .student-board__modal-description a {
                color: var(--sb-accent);
                text-decoration: none;
            }

            .student-board__modal-description a:hover {
                text-decoration: underline;
            }

            .student-board__modal-description strong {
                font-weight: 600;
            }

            .student-board__modal-description em {
                font-style: italic;
            }

            .student-board__modal-description hr {
                border: none;
                border-top: 1px solid var(--sb-border);
                margin: 1.5em 0;
            }

            @media (max-width: 768px) {
            .student-board {
                padding: 1.25rem;
            }

            .student-board__columns {
                grid-template-columns: 1fr;
            }

            .student-board__modal-header-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .student-board__modal-header-row .student-board__modal-select {
                width: 100%;
            }
        }
    </style>

    <div class="student-board__intro">
        <div class="student-board__project">
            <p class="text-sm" style="margin:0;color:var(--sb-text-muted);">{{ __('student.title.student_panel') }}</p>
            <h2>{{ $board['enrollment']['project'] ?? 'Projekt' }}</h2>
            <p>{{ __('student.title.copy_name') ?? 'Twoja kopia' }}: <strong>{{ $board['enrollment']['name'] }}</strong>
            </p>
        </div>
        <div class="student-board__selector">
            <label for="{{ $boardDomId }}-stage">{{ __('student.table.stage') ?? 'Etap' }}</label>
            <select id="{{ $boardDomId }}-stage" data-stage-select></select>
        </div>
    </div>

    <div class="student-board__stage-card">
        <div class="student-board__stage-header">
            <div>
                <p class="text-sm" style="margin:0;color:var(--sb-text-muted);">
                    {{ __('student.table.stage') ?? 'Etap' }}
                </p>
                <h3 data-stage-name>–</h3>
            </div>
            <div class="student-board__stage-meta">
                <span class="status-pill" data-stage-status>–</span>
                <div>
                    <p style="margin:0;font-size:0.75rem;color:var(--sb-text-muted);">
                        {{ __('student.table.stage_progress') ?? 'Postęp etapu' }}
                    </p>
                    <strong style="font-size:1rem;" data-stage-progress-inline>0%</strong>
                </div>
            </div>
        </div>
        <p class="student-board__stage-description" data-stage-description></p>
        <p class="student-board__lock" data-stage-locked hidden>
            {{ __('student.board.locked') ?? 'Najpierw ukończ poprzedni etap.' }}
        </p>
    </div>

    <div class="student-board__columns" data-board-columns></div>
    <p class="student-board__empty" data-board-empty hidden>
        {{ __('student.board.no_tasks') ?? 'Brak zadań w tym projekcie.' }}
    </p>

    <div class="student-board__hint">
        {{ __('student.board.hint') ?? 'Przeciągaj zadania, aby aktualizować postęp i odblokowywać kolejne etapy.' }}
    </div>

    <div class="student-board__message" data-board-message></div>

    <div class="student-board__modal" data-task-modal hidden>
        <div class="student-board__modal-panel">
            <div style="display: flex; justify-content: flex-end; margin-bottom: 0.5rem;">
                <button type="button" class="student-board__modal-close" data-task-modal-close
                    aria-label="{{ __('student.board.close') ?? 'Zamknij' }}">&times;</button>
            </div>
            <div class="student-board__modal-header-row">
                <h4 data-modal-title></h4>
                <select data-modal-status-select class="student-board__modal-select"></select>
            </div>
            <dl class="student-board__modal-details">
                <div>
                    <dt>{{ __('student.table.stage') ?? 'Etap' }}</dt>
                    <dd data-modal-stage></dd>
                </div>
                <div>
                    <dt>{{ __('student.board.description') ?? 'Opis' }}</dt>
                    <dd data-modal-description class="student-board__modal-description"></dd>
                </div>
            </dl>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <!-- Marked.js for markdown rendering -->
        <script src="https://cdn.jsdelivr.net/npm/marked@11.1.1/marked.min.js"></script>
        <script>
            (() => {
                const stageStatusLabels = {
                    pending: {!! json_encode(__('student.board.status_pending') ?? 'Oczekuje') !!},
                    in_progress: {!! json_encode(__('student.board.status_in_progress') ?? 'W toku') !!},
                    completed: {!! json_encode(__('student.board.status_completed') ?? 'Zakończony') !!},
                };

                const columnLabels = {
                    todo: {!! json_encode(__('student.board.todo') ?? 'Do zrobienia') !!},
                    in_progress: {!! json_encode(__('student.board.in_progress') ?? 'W toku') !!},
                    done: {!! json_encode(__('student.board.done') ?? 'Zakończone') !!},
                };

                const messages = {
                    saved: {!! json_encode(__('student.board.saved') ?? 'Zapisano postęp.') !!},
                    completed: {!! json_encode(__('student.board.completed') ?? 'Gratulacje! Ukończyłeś projekt.') !!},
                    error: {!! json_encode(__('student.board.error') ?? 'Nie udało się zapisać zmian. Spróbuj ponownie.') !!},
                };

                const formatPercent = (value) => `${Math.max(0, Math.min(100, Math.round(value ?? 0)))}%`;

                const ready = () => {
                    document.querySelectorAll('[data-student-board]').forEach(setupBoard);
                };

                document.readyState === 'loading'
                    ? document.addEventListener('DOMContentLoaded', ready, { once: true })
                    : ready();

                function setupBoard(wrapper) {
                    if (wrapper.dataset.studentBoardInitialized) {
                        return;
                    }
                    wrapper.dataset.studentBoardInitialized = '1';

                    let state;

                    try {
                        state = normalizeState(JSON.parse(wrapper.dataset.board || '{}'));
                    } catch (error) {
                        console.error('Cannot parse board payload', error);
                        return;
                    }

                    if (!state.stages.length) {
                        return;
                    }

                    const elements = {
                        board: wrapper,
                        stageSelect: wrapper.querySelector('[data-stage-select]'),
                        stageName: wrapper.querySelector('[data-stage-name]'),
                        stageStatus: wrapper.querySelector('[data-stage-status]'),
                        stageDescription: wrapper.querySelector('[data-stage-description]'),
                        stageLock: wrapper.querySelector('[data-stage-locked]'),
                        stageProgressPrimary: wrapper.querySelector('[data-stage-progress]'),
                        stageProgressInline: wrapper.querySelector('[data-stage-progress-inline]'),
                        stageCount: wrapper.querySelector('[data-stage-count]'),
                        columns: wrapper.querySelector('[data-board-columns]'),
                        emptyState: wrapper.querySelector('[data-board-empty]'),
                        message: wrapper.querySelector('[data-board-message]'),
                        modal: wrapper.querySelector('[data-task-modal]'),
                        modalTitle: wrapper.querySelector('[data-modal-title]'),
                        modalStage: wrapper.querySelector('[data-modal-stage]'),
                        modalTitle: wrapper.querySelector('[data-modal-title]'),
                        modalStage: wrapper.querySelector('[data-modal-stage]'),
                        modalStatusSelect: wrapper.querySelector('[data-modal-status-select]'),
                        modalDescription: wrapper.querySelector('[data-modal-description]'),
                        modalDescription: wrapper.querySelector('[data-modal-description]'),
                        modalCloseButtons: wrapper.querySelectorAll('[data-task-modal-close]'),
                    };

                    let selectedStageId = state.selectedStageId;
                    let syncTimer = null;
                    let isSyncing = false;
                    let escHandler = null;

                    const renderAll = () => {
                        renderStagesSelect();
                        renderStageCard();
                        renderColumns();
                    };

                    const getStageById = (id) => state.stages.find((stage) => stage.id === id);

                    const setSelectedStage = (stageId) => {
                        if (!getStageById(stageId)) {
                            return;
                        }

                        selectedStageId = stageId;
                        state.selectedStageId = stageId;
                        renderAll();
                    };

                    const renderStagesSelect = () => {
                        if (elements.stageSelect) {
                            elements.stageSelect.innerHTML = '';
                            state.stages.forEach((stage) => {
                                const option = document.createElement('option');
                                option.value = stage.id;
                                option.textContent = `${stage.order}. ${stage.name}`;
                                option.selected = stage.id === selectedStageId;
                                elements.stageSelect.appendChild(option);
                            });
                        }
                    };

                    const canEditStage = (stage) => {
                        if (!state.activeStageId) {
                            return false;
                        }

                        return stage.id === state.activeStageId;
                    };

                    const renderStageCard = () => {
                        const stage = getStageById(selectedStageId);
                        if (!stage) {
                            return;
                        }

                        const cache = stage.status_cache || {};
                        const editable = canEditStage(stage);

                        elements.stageName.textContent = stage.name;
                        elements.stageDescription.textContent = stage.description?.trim()?.length
                            ? stage.description
                            : {!! json_encode(__('student.board.stage_description_empty') ?? 'Brak opisu tego etapu.') !!};
                        elements.stageStatus.textContent = stageStatusLabels[stage.status] || stage.status;
                        if (elements.stageProgressPrimary) {
                            elements.stageProgressPrimary.textContent = formatPercent(cache.progress ?? 0);
                        }
                        if (elements.stageProgressInline) {
                            elements.stageProgressInline.textContent = formatPercent(cache.progress ?? 0);
                        }
                        if (elements.stageCount) {
                            elements.stageCount.textContent = `${cache.tasks_done ?? 0} / ${cache.tasks_total ?? stage.tasks.length}`;
                        }
                        elements.stageLock.hidden = editable || stage.status === 'completed' || state.activeStageId === null;
                        elements.stageLock.textContent = {!! json_encode(__('student.board.locked') ?? 'Najpierw ukończ poprzedni etap.') !!};
                    };

                    const renderColumns = () => {
                        const stage = getStageById(selectedStageId);
                        if (!stage || !elements.columns) {
                            return;
                        }

                        const editable = canEditStage(stage);
                        const fragment = document.createDocumentFragment();
                        const sortedColumns = [...state.columns].sort((a, b) => (a.order ?? 0) - (b.order ?? 0));
                        const tasks = [...stage.tasks];

                        elements.emptyState.hidden = tasks.length > 0;
                        elements.columns.innerHTML = '';

                        sortedColumns.forEach((column) => {
                            const columnTasks = tasks
                                .filter((task) => (task.status || 'todo') === column.id)
                                .sort((a, b) => (a.order ?? 0) - (b.order ?? 0));

                            const columnEl = document.createElement('section');
                            columnEl.className = 'student-board__column';
                            columnEl.dataset.column = column.id;

                            const header = document.createElement('header');
                            const title = document.createElement('span');
                            title.textContent = column.name || columnLabels[column.id] || column.id;
                            const count = document.createElement('span');
                            count.className = 'student-board__column-count';
                            count.textContent = columnTasks.length;
                            header.appendChild(title);
                            header.appendChild(count);

                            const tasksWrapper = document.createElement('div');
                            tasksWrapper.className = 'student-board__tasks';
                            tasksWrapper.dataset.columnTasks = '';

                            columnTasks.forEach((task) => {
                                const taskEl = document.createElement('article');
                                taskEl.className = 'student-board__task';
                                taskEl.dataset.taskId = task.id;
                                taskEl.draggable = editable;

                                const titleEl = document.createElement('h4');
                                titleEl.textContent = task.title || task.name || 'Zadanie';

                                const meta = document.createElement('div');
                                meta.className = 'student-board__task-meta';
                                const priorityLabel = task.priority && task.priority !== 'normal' ? task.priority : '';
                                const timeLabel = task.timeEstimate ? `${task.timeEstimate}h` : '';
                                meta.innerHTML = `
                                                                                    <span>${priorityLabel}</span>
                                                                                    <span>${timeLabel}</span>
                                                                                `;

                                const actions = document.createElement('div');
                                actions.className = 'student-board__task-actions';
                                const button = document.createElement('button');
                                button.type = 'button';
                                button.className = 'student-board__task-button';
                                button.dataset.taskDetails = task.id;
                                button.textContent = {!! json_encode(__('student.board.view_description') ?? 'Szczegóły') !!};
                                actions.appendChild(button);

                                taskEl.appendChild(titleEl);
                                taskEl.appendChild(meta);
                                taskEl.appendChild(actions);
                                tasksWrapper.appendChild(taskEl);
                            });

                            columnEl.appendChild(header);
                            columnEl.appendChild(tasksWrapper);
                            fragment.appendChild(columnEl);
                        });

                        elements.columns.appendChild(fragment);
                        setupDnD(stage, editable);
                    };

                    const setupDnD = (stage, editable) => {
                        if (!editable) {
                            return;
                        }

                        const taskEls = elements.columns.querySelectorAll('.student-board__task');
                        const containers = elements.columns.querySelectorAll('[data-column]');

                        taskEls.forEach((taskEl) => {
                            taskEl.addEventListener('dragstart', (event) => {
                                event.dataTransfer.effectAllowed = 'move';
                                taskEl.classList.add('is-dragging');
                            });

                            taskEl.addEventListener('dragend', () => {
                                taskEl.classList.remove('is-dragging');
                            });
                        });

                        containers.forEach((column) => {
                            const tasksWrapper = column.querySelector('[data-column-tasks]') || column.querySelector('.student-board__tasks');

                            column.addEventListener('dragover', (event) => {
                                event.preventDefault();
                                const afterElement = getDragAfterElement(tasksWrapper, event.clientY);
                                const dragging = elements.columns.querySelector('.student-board__task.is-dragging');
                                if (!dragging) {
                                    return;
                                }

                                if (!afterElement) {
                                    tasksWrapper.appendChild(dragging);
                                } else {
                                    tasksWrapper.insertBefore(dragging, afterElement);
                                }
                            });

                            column.addEventListener('dragenter', () => {
                                tasksWrapper.classList.add('is-hover');
                            });

                            column.addEventListener('dragleave', (event) => {
                                if (!column.contains(event.relatedTarget)) {
                                    tasksWrapper.classList.remove('is-hover');
                                }
                            });

                            column.addEventListener('drop', (event) => {
                                event.preventDefault();
                                tasksWrapper.classList.remove('is-hover');
                                refreshStageTasksFromDom(stage);
                                updateStageCache(stage);
                                renderStageCard();
                                scheduleSync(stage.id);
                            });
                        });
                    };

                    const refreshStageTasksFromDom = (stage) => {
                        const orderedIds = [];
                        elements.columns.querySelectorAll('[data-column]').forEach((columnEl) => {
                            const columnId = columnEl.dataset.column;
                            const cards = columnEl.querySelectorAll('[data-task-id]');
                            cards.forEach((card) => {
                                const task = stage.tasks.find((t) => t.id === card.dataset.taskId);
                                if (task) {
                                    task.status = columnId;
                                    orderedIds.push(task.id);
                                }
                            });
                        });

                        orderedIds.forEach((taskId, index) => {
                            const task = stage.tasks.find((t) => t.id === taskId);
                            if (task) {
                                task.order = index + 1;
                            }
                        });
                    };

                    const updateStageCache = (stage) => {
                        const total = stage.tasks.length;
                        const done = stage.tasks.filter((task) => task.status === 'done').length;
                        const inProgress = stage.tasks.filter((task) => task.status === 'in_progress').length;
                        stage.status_cache = {
                            tasks_total: total,
                            tasks_done: done,
                            tasks_in_progress: inProgress,
                            progress: total ? Math.round((done / total) * 100) : 0,
                        };
                    };

                    const getDragAfterElement = (container, y) => {
                        const elements = [...container.querySelectorAll('.student-board__task:not(.is-dragging)')];
                        return elements.reduce((closest, child) => {
                            const box = child.getBoundingClientRect();
                            const offset = y - box.top - box.height / 2;
                            if (offset < 0 && offset > closest.offset) {
                                return { offset, element: child };
                            }
                            return closest;
                        }, { offset: Number.NEGATIVE_INFINITY }).element;
                    };

                    const scheduleSync = (stageId) => {
                        if (!state.syncUrl) {
                            return;
                        }

                        clearTimeout(syncTimer);
                        syncTimer = setTimeout(() => persistStage(stageId), 500);
                    };

                    const persistStage = async (stageId) => {
                        if (isSyncing) {
                            return;
                        }

                        const stage = getStageById(stageId);
                        if (!stage) {
                            return;
                        }

                        isSyncing = true;
                        setMessage('info', {!! json_encode(__('student.board.saving') ?? 'Zapisywanie...') !!});

                        try {
                            const response = await fetch(state.syncUrl.replace('__STAGE__', stage.id), {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': state.csrfToken,
                                },
                                body: JSON.stringify({
                                    tasks: stage.tasks.map((task) => ({
                                        id: task.id,
                                        status: task.status,
                                        order: task.order ?? 0,
                                    })),
                                }),
                            });

                            if (!response.ok) {
                                throw new Error('Request failed');
                            }

                            const payload = await response.json();
                            handleSyncPayload(payload, stage.id);
                        } catch (error) {
                            console.error(error);
                            setMessage('error', messages.error);
                        } finally {
                            isSyncing = false;
                        }
                    };

                    const handleSyncPayload = (payload, stageId) => {
                        const stage = getStageById(stageId);
                        if (!stage) {
                            return;
                        }

                        if (payload.stage) {
                            stage.status = payload.stage.status ?? stage.status;
                            stage.status_cache = payload.stage.status_cache ?? stage.status_cache;
                            stage.started_at = payload.stage.started_at ?? stage.started_at;
                            stage.completed_at = payload.stage.completed_at ?? stage.completed_at;
                        }

                        if (payload.enrollment) {
                            state.enrollment.status = payload.enrollment.status ?? state.enrollment.status;
                            state.enrollment.status_cache = payload.enrollment.status_cache ?? state.enrollment.status_cache;
                            state.activeStageId = payload.enrollment.current_stage_id
                                ? String(payload.enrollment.current_stage_id)
                                : null;
                        }

                        if (payload.message) {
                            setMessage('success', payload.message);
                        } else if (!state.activeStageId) {
                            setMessage('success', messages.completed);
                        } else {
                            setMessage('success', messages.saved);
                        }

                        if (state.activeStageId && selectedStageId !== state.activeStageId) {
                            selectedStageId = state.activeStageId;
                        }

                        renderAll();
                    };

                    const setMessage = (type, text) => {
                        if (!elements.message) {
                            return;
                        }

                        if (!text) {
                            elements.message.removeAttribute('data-state');
                            elements.message.textContent = '';
                            elements.message.style.display = 'none';
                            return;
                        }

                        elements.message.dataset.state = type;
                        elements.message.textContent = text;
                        elements.message.style.display = 'block';
                    };

                    const openModal = (task) => {
                        if (!elements.modal) {
                            return;
                        }

                        const stage = getStageById(selectedStageId);
                        elements.modalTitle.textContent = task.title || 'Zadanie';
                        elements.modalStage.textContent = stage?.name ?? '';

                        // Populate status select
                        if (elements.modalStatusSelect) {
                            elements.modalStatusSelect.innerHTML = '';
                            state.columns.forEach(column => {
                                const option = document.createElement('option');
                                option.value = column.id;
                                option.textContent = column.name || columnLabels[column.id] || column.id;
                                option.selected = task.status === column.id;
                                elements.modalStatusSelect.appendChild(option);
                            });

                            // Remove old listener if exists to avoid duplicates (simplified approach: clone node)
                            const newSelect = elements.modalStatusSelect.cloneNode(true);
                            elements.modalStatusSelect.parentNode.replaceChild(newSelect, elements.modalStatusSelect);
                            elements.modalStatusSelect = newSelect;

                            elements.modalStatusSelect.addEventListener('change', (e) => {
                                const newStatus = e.target.value;
                                updateTaskStatus(task.id, newStatus);
                            });

                            // Disable if stage is not editable
                            elements.modalStatusSelect.disabled = !canEditStage(stage);
                        }

                        // Render markdown description
                        const descriptionText = task.description?.trim()?.length
                            ? task.description
                            : {!! json_encode(__('student.board.description_empty') ?? 'Brak opisu zadania.') !!};
                        
                        // Use marked.js to render markdown if available
                        if (typeof marked !== 'undefined' && task.description?.trim()?.length) {
                            elements.modalDescription.innerHTML = marked.parse(descriptionText);
                        } else {
                            elements.modalDescription.textContent = descriptionText;
                        }
                        elements.modal.hidden = false;
                        document.body.dataset.studentBoardModalOpen = '1';

                        escHandler = (event) => {
                            if (event.key === 'Escape') {
                                closeModal();
                            }
                        };

                        document.addEventListener('keydown', escHandler);
                    };

                    const updateTaskStatus = (taskId, newStatus) => {
                        const stage = getStageById(selectedStageId);
                        const task = stage.tasks.find(t => t.id === taskId);
                        if (task && task.status !== newStatus) {
                            task.status = newStatus;
                            renderColumns(); // Re-render columns to move task
                            updateStageCache(stage);
                            renderStageCard();
                            scheduleSync(stage.id);
                        }
                    };

                    const closeModal = () => {
                        if (!elements.modal) {
                            return;
                        }

                        elements.modal.hidden = true;
                        document.body.removeAttribute('data-student-board-modal-open');
                        if (escHandler) {
                            document.removeEventListener('keydown', escHandler);
                            escHandler = null;
                        }
                    };

                    const syncTheme = () => {
                        const isDark = document.documentElement.classList.contains('dark');
                        wrapper.dataset.theme = isDark ? 'dark' : 'light';
                    };

                    const observer = new MutationObserver(syncTheme);
                    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
                    syncTheme();

                    elements.stageSelect?.addEventListener('change', (event) => {
                        setSelectedStage(String(event.target.value));
                    });

                    elements.columns?.addEventListener('click', (event) => {
                        const button = event.target.closest('[data-task-details]');
                        if (!button) {
                            return;
                        }

                        const taskEl = button.closest('[data-task-id]');
                        if (!taskEl) {
                            return;
                        }

                        const stage = getStageById(selectedStageId);
                        const task = stage?.tasks.find((t) => t.id === taskEl.dataset.taskId);
                        if (task) {
                            openModal(task);
                        }
                    });

                    elements.modal?.addEventListener('click', (event) => {
                        if (event.target === elements.modal) {
                            closeModal();
                        }
                    });

                    elements.modalCloseButtons.forEach((button) => button.addEventListener('click', closeModal));

                    renderAll();
                }

                function normalizeState(raw) {
                    const stages = (raw.stages || []).map((stage, index) => ({
                        ...stage,
                        id: String(stage.id ?? index),
                        order: stage.order ?? index + 1,
                        status: stage.status ?? 'pending',
                        tasks: (stage.tasks || []).map((task, taskIndex) => ({
                            ...task,
                            id: String(task.id ?? `${stage.id}-${taskIndex}`),
                            status: task.status ?? 'todo',
                            title: task.title ?? task.name ?? 'Zadanie',
                            description: task.description ?? '',
                            order: task.order ?? taskIndex + 1,
                            priority: task.priority ?? 'normal',
                            timeEstimate: task.timeEstimate ?? task.planned_duration ?? null,
                        })),
                        status_cache: stage.status_cache ?? {
                            tasks_total: stage.tasks?.length ?? 0,
                            tasks_done: 0,
                            tasks_in_progress: 0,
                            progress: 0,
                        },
                    })).sort((a, b) => (a.order ?? 0) - (b.order ?? 0));

                    const columns = (raw.columns || []).map((column, index) => ({
                        ...column,
                        id: String(column.id ?? index),
                        name: column.name ?? columnLabels[column.id] ?? column.id,
                        order: column.order ?? index + 1,
                    }));

                    const fallbackActive = stages.find((stage) => stage.status !== 'completed')?.id ?? null;
                    const activeStageId = raw.activeStageId ? String(raw.activeStageId) : fallbackActive;
                    const selectedStageId = activeStageId ?? (stages[0]?.id ?? null);

                    return {
                        stages,
                        columns,
                        activeStageId,
                        selectedStageId,
                        enrollment: raw.enrollment ?? {},
                        syncUrl: raw.syncUrl ?? null,
                        csrfToken: raw.csrfToken ?? document.querySelector('meta[name=\'csrf-token\']')?.getAttribute('content'),
                    };
                }
            })();
        </script>
    @endpush
@endonce