<!DOCTYPE html>
<html lang="pl" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Scrum - Zarządzanie Projektami</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Dark Theme (Default) */
        [data-theme="dark"] {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #0f172a;
            --border-color: #334155;
            --border-color-light: #475569;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-tertiary: #94a3b8;
            --card-bg: #ffffff;
            --card-text: #0f172a;
            --card-text-secondary: #475569;
            --task-time-color: #64748b;
            --accent-primary: #f59e0b;
            --accent-primary-hover: #d97706;
            --accent-success: #10b981;
            --accent-success-hover: #059669;
            --modal-bg: #1e293b;
            --input-bg: #0f172a;
            --input-border: #475569;
            --input-focus-border: #f59e0b;
            --count-bg: #334155;
            --count-text: #cbd5e1;
            --hint-bg: #1e293b;
            --hint-border: #334155;
            --hint-text: #cbd5e1;
            --button-cancel-bg: #334155;
            --button-cancel-hover: #475569;
            --icon-color: #64748b;
            --icon-hover: #f59e0b;
            --icon-delete-hover: #ef4444;
            --body-gradient-start: #0f172a;
            --body-gradient-end: #1e293b;
        }

        /* Light Theme */
        [data-theme="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #f9fafb;
            --bg-tertiary: #ffffff;
            --border-color: #e5e7eb;
            --border-color-light: #d1d5db;
            --text-primary: #0f172a;
            --text-secondary: #374151;
            --text-tertiary: #6b7280;
            --card-bg: #ffffff;
            --card-text: #0f172a;
            --card-text-secondary: #475569;
            --task-time-color: #64748b;
            --accent-primary: #f59e0b;
            --accent-primary-hover: #d97706;
            --accent-success: #10b981;
            --accent-success-hover: #059669;
            --modal-bg: #ffffff;
            --input-bg: #ffffff;
            --input-border: #d1d5db;
            --input-focus-border: #f59e0b;
            --count-bg: #f3f4f6;
            --count-text: #374151;
            --hint-bg: #f9fafb;
            --hint-border: #e5e7eb;
            --hint-text: #374151;
            --button-cancel-bg: #f3f4f6;
            --button-cancel-hover: #e5e7eb;
            --icon-color: #9ca3af;
            --icon-hover: #f59e0b;
            --icon-delete-hover: #ef4444;
            --body-gradient-start: #f9fafb;
            --body-gradient-end: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background: linear-gradient(135deg, var(--body-gradient-start) 0%, var(--body-gradient-end) 100%);
            min-height: 100vh;
            padding: 20px;
            transition: background 0.3s ease;
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
        }

        header {
            background: var(--bg-secondary);
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        h1 {
            color: var(--text-primary);
            font-size: 28px;
            font-weight: 700;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--accent-primary);
            color: #ffffff;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: var(--accent-primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }

        .btn-secondary {
            background: var(--accent-success);
            color: white;
        }

        .btn-secondary:hover {
            background: var(--accent-success-hover);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
            transform: translateY(-1px);
        }

        .btn-theme {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-theme:hover {
            background: var(--bg-secondary);
            border-color: var(--border-color-light);
            transform: translateY(-1px);
        }

        .hint-box {
            background: var(--hint-bg);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            color: var(--hint-text);
            border: 1px solid var(--hint-border);
            transition: all 0.3s ease;
        }

        .board {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .column {
            background: var(--bg-secondary);
            border-radius: 12px;
            padding: 15px;
            min-height: 500px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .column-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 12px;
            background: var(--bg-tertiary);
            border-radius: 8px;
            border-left: 3px solid;
            transition: all 0.3s ease;
        }

        .column-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .task-count {
            background: var(--count-bg);
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            color: var(--count-text);
            transition: all 0.3s ease;
        }

        .tasks-container {
            min-height: 400px;
        }

        .task-card {
            background: var(--card-bg);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            cursor: grab;
            transition: all 0.2s ease;
            border: 1px solid var(--border-color);
            border-left-width: 3px;
        }

        .task-card:active {
            cursor: grabbing;
        }

        .task-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
            border-color: var(--border-color-light);
        }

        .task-card.dragging {
            opacity: 0.5;
            cursor: grabbing;
            transform: rotate(3deg) scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 10px;
        }

        .task-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--card-text);
            flex: 1;
        }

        .task-priority {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-left: 10px;
            letter-spacing: 0.5px;
        }

        .priority-high {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .priority-medium {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }

        .priority-low {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .task-description {
            color: var(--card-text-secondary);
            font-size: 14px;
            margin-bottom: 12px;
            line-height: 1.6;
        }

        .task-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
            border-top: 1px solid var(--border-color);
        }

        .task-time {
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--task-time-color);
            font-size: 13px;
            font-weight: 500;
        }

        .task-actions {
            display: flex;
            gap: 5px;
        }

        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            color: var(--icon-color);
            transition: color 0.2s;
        }

        .icon-btn:hover {
            color: var(--icon-hover);
        }

        .icon-btn.delete:hover {
            color: var(--icon-delete-hover);
        }

        .drop-indicator {
            height: 3px;
            background: linear-gradient(90deg, transparent, #f59e0b, transparent);
            border-radius: 2px;
            margin: 6px 0;
            opacity: 0;
            transition: opacity 0.2s ease;
            animation: pulse 1s ease-in-out infinite;
        }

        .drop-indicator.active {
            opacity: 1;
        }

        @keyframes pulse {
            0%, 100% {
                background: linear-gradient(90deg, transparent, #f59e0b, transparent);
            }
            50% {
                background: linear-gradient(90deg, transparent, #fb923c, transparent);
            }
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--modal-bg);
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .modal-header {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--text-primary);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--input-border);
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
            background: var(--input-bg);
            color: var(--text-primary);
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--input-focus-border);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
            background: var(--modal-bg);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: var(--text-tertiary);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 25px;
        }

        .btn-cancel {
            background: var(--button-cancel-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-cancel:hover {
            background: var(--button-cancel-hover);
            transform: translateY(-1px);
        }

        /* Priority & Column Colors */
        .task-card[data-priority="high"] {
            border-left-color: #ef4444;
        }

        .task-card[data-priority="medium"] {
            border-left-color: #f59e0b;
        }

        .task-card[data-priority="low"] {
            border-left-color: #10b981;
        }
/*
        .column[data-column="todo"] .column-header {
            border-left-color: #64748b;
        }

        .column[data-column="backlog"] .column-header {
            border-left-color: #9c122dff;
        }

        .column[data-column="inprogress"] .column-header {
            border-left-color: #3b82f6;
        }

        .column[data-column="testing"] .column-header {
            border-left-color: #f59e0b;
        }

        .column[data-column="done"] .column-header {
            border-left-color: #10b981;
        }
*/
        /* Responsive */
        @media (max-width: 768px) {
            .board {
                grid-template-columns: 1fr;
            }

            header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .header-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
            }

            h1 {
                font-size: 22px;
                text-align: center;
            }
        }
        .hide {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="hide">
            <h1>📋 System Scrum - Zarządzanie Projektami <span style="font-size: 14px; color: #f59e0b; font-weight: 500; margin-left: 10px;">Filament Design</span></h1>
            <div class="header-actions">
                <button class="btn btn-theme" onclick="toggleTheme()">
                    <span id="themeIcon">🌙</span>
                    <span id="themeText">Ciemny</span>
                </button>
                <button class="btn btn-primary" onclick="openAddTaskModal()">+ Nowe zadanie</button>
                <button class="btn btn-secondary" onclick="exportToJSON()">💾 Eksport JSON</button>
            </div>
        </header>

        <div class="hint-box hide">
            <strong style="color: #f59e0b;">💡 Wskazówka:</strong> Przeciągnij zadania aby zmienić ich kolejność w kolumnie lub przenieść między kolumnami
        </div>

        <div class="board" id="scrumBoard"></div>
    </div>

    <!-- Modal -->
    <div class="modal" id="taskModal">
        <div class="modal-content">
            <div class="modal-header" id="modalTitle">Nowe zadanie</div>
            <form id="taskForm">
                <div class="form-group">
                    <label for="taskTitle">Tytuł *</label>
                    <input type="text" id="taskTitle" required placeholder="Wprowadź tytuł zadania">
                </div>
                <div class="form-group">
                    <label for="taskDescription">Opis</label>
                    <textarea id="taskDescription" placeholder="Opisz zadanie szczegółowo..."></textarea>
                </div>
                <div class="form-group">
                    <label for="taskPriority">Priorytet *</label>
                    <select id="taskPriority" required>
                        <option value="low">Niski</option>
                        <option value="medium" selected>Średni</option>
                        <option value="high">Wysoki</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="taskTime">Czas realizacji (godziny) *</label>
                    <input type="number" id="taskTime" min="0.5" step="0.5" value="1" required>
                </div>
                <div class="form-group">
                    <label for="taskColumn">Kolumna *</label>
                    <select id="taskColumn" required></select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeTaskModal()">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Konfiguracja
        let scrumConfig = {
            columns: [
                { id: "backlog", name: "Backlog", order: 4, color: "#9c122dff" },
                { id: "todo", name: "Do zrobienia", order: 1 , color: "#64748b" },
                { id: "inprogress", name: "W trakcie", order: 2, color: "#3b82f6" },
                { id: "testing", name: "Testowanie", order: 3, color: "#f59e0b" },
                { id: "done", name: "Zakończone", order: 4, color: "#10b981" }
            ],
            tasks: [
                {
                    id: 1,
                    title: "Zaprojektowanie interfejsu użytkownika",
                    description: "Stworzenie wireframe'ów i mockupów dla nowej aplikacji",
                    priority: "high",
                    timeEstimate: 8,
                    columnId: "backlog"
                },
                {
                    id: 2,
                    title: "Implementacja API REST",
                    description: "Utworzenie endpointów dla operacji CRUD",
                    priority: "high",
                    timeEstimate: 12,
                    columnId: "inprogress"
                },
                {
                    id: 3,
                    title: "Testy jednostkowe",
                    description: "Napisanie testów dla modułu autoryzacji",
                    priority: "medium",
                    timeEstimate: 6,
                    columnId: "todo"
                },
                {
                    id: 4,
                    title: "Dokumentacja techniczna",
                    description: "Przygotowanie dokumentacji API i architektury",
                    priority: "low",
                    timeEstimate: 4,
                    columnId: "todo"
                },
                {
                    id: 5,
                    title: "Optymalizacja bazy danych",
                    description: "Dodanie indeksów i optymalizacja zapytań",
                    priority: "medium",
                    timeEstimate: 5,
                    columnId: "testing"
                },
                {
                    id: 6,
                    title: "Konfiguracja CI/CD",
                    description: "Ustawienie pipeline'u dla automatycznego wdrażania",
                    priority: "high",
                    timeEstimate: 10,
                    columnId: "done"
                },
                {
                    id: 7,
                    title: "Code Review",
                    description: "Przegląd kodu z zespołem przed merge'em",
                    priority: "medium",
                    timeEstimate: 3,
                    columnId: "testing"
                },
                {
                    id: 8,
                    title: "Aktualizacja zależności",
                    description: "Update packages i check security vulnerabilities",
                    priority: "low",
                    timeEstimate: 2,
                    columnId: "done"
                }
            ]
        };

        let currentEditingTask = null;
        let draggedElement = null;

        // Theme Management
        function initTheme() {
            const savedTheme = window.localStorage ? localStorage.getItem('scrumTheme') : null;
            const theme = savedTheme || 'dark';
            document.documentElement.setAttribute('data-theme', theme);
            updateThemeButton(theme);
        }

        function toggleTheme() {
            const current = document.documentElement.getAttribute('data-theme');
            const newTheme = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            if (window.localStorage) localStorage.setItem('scrumTheme', newTheme);
            updateThemeButton(newTheme);
        }

        function updateThemeButton(theme) {
            const icon = document.getElementById('themeIcon');
            const text = document.getElementById('themeText');
            if (theme === 'dark') {
                icon.textContent = '🌙';
                text.textContent = 'Ciemny';
            } else {
                icon.textContent = '☀️';
                text.textContent = 'Jasny';
            }
        }

        // Board Rendering
        function init() {
            initTheme();
            renderBoard();
            populateColumnSelect();
        }

        function renderBoard() {
            const board = document.getElementById('scrumBoard');
            board.innerHTML = '';
            scrumConfig.columns.sort((a, b) => a.order - b.order).forEach(col => {
                board.appendChild(createColumn(col));
            });
        }

        function createColumn(column) {
            const div = document.createElement('div');
            div.className = 'column';
            div.setAttribute('data-column', column.id);

            const tasks = scrumConfig.tasks.filter(t => t.columnId === column.id);

            div.innerHTML = `
                <div class="column-header" style="border-left-color: ${column.color};">
                    <span class="column-title">${column.name}</span>
                    <span class="task-count">${tasks.length}</span>
                </div>
                <div class="tasks-container" data-column-id="${column.id}"></div>
            `;

            const container = div.querySelector('.tasks-container');
            container.addEventListener('dragover', handleDragOver);
            container.addEventListener('drop', handleDrop);
            container.addEventListener('dragleave', handleDragLeave);

            tasks.forEach(task => container.appendChild(createTaskCard(task)));
            return div;
        }

        function createTaskCard(task) {
            const card = document.createElement('div');
            card.className = 'task-card';
            card.draggable = true;
            card.setAttribute('data-task-id', task.id);
            card.setAttribute('data-priority', task.priority);

            const labels = { high: 'Wysoki', medium: 'Średni', low: 'Niski' };

            card.innerHTML = `
                <div class="task-header">
                    <div class="task-title">${task.title}</div>
                    <div class="task-priority priority-${task.priority}">${labels[task.priority]}</div>
                </div>
                <div class="task-description">${task.description || 'Brak opisu'}</div>
                <div class="task-footer">
                    <div class="task-time">⏱️ ${task.timeEstimate}h</div>
                    <div class="task-actions">
                        <button class="icon-btn" onclick="editTask(${task.id})">✏️</button>
                        <button class="icon-btn delete" onclick="deleteTask(${task.id})">🗑️</button>
                    </div>
                </div>
            `;

            card.addEventListener('dragstart', handleDragStart);
            card.addEventListener('dragend', handleDragEnd);
            return card;
        }

        // Drag & Drop
        function handleDragStart(e) {
            draggedElement = this;
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
        }

        function handleDragEnd(e) {
            this.classList.remove('dragging');
            document.querySelectorAll('.drop-indicator').forEach(el => el.remove());
        }

        function handleDragOver(e) {
            e.preventDefault();
            const afterEl = getDragAfterElement(this, e.clientY);
            const draggable = document.querySelector('.dragging');

            const existing = this.querySelector('.drop-indicator');
            if (existing) existing.remove();

            const indicator = document.createElement('div');
            indicator.className = 'drop-indicator active';

            if (!afterEl) {
                this.appendChild(indicator);
                this.appendChild(draggable);
            } else {
                this.insertBefore(indicator, afterEl);
                this.insertBefore(draggable, afterEl);
            }
        }

        function handleDragLeave(e) {
            if (e.target === this && !this.contains(e.relatedTarget)) {
                const indicator = this.querySelector('.drop-indicator');
                if (indicator) indicator.remove();
            }
        }

        function handleDrop(e) {
            e.stopPropagation();
            document.querySelectorAll('.drop-indicator').forEach(el => el.remove());

            if (draggedElement) {
                const taskId = parseInt(draggedElement.getAttribute('data-task-id'));
                const newColumnId = this.getAttribute('data-column-id');
                const task = scrumConfig.tasks.find(t => t.id === taskId);

                if (task) {
                    task.columnId = newColumnId;
                    updateTaskOrder(newColumnId);
                    updateTaskCounts();
                    saveToJSON();
                }
            }
        }

        function getDragAfterElement(container, y) {
            const elements = [...container.querySelectorAll('.task-card:not(.dragging)')];
            return elements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return { offset, element: child };
                }
                return closest;
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }

        function updateTaskOrder(columnId) {
            const container = document.querySelector(`[data-column-id="${columnId}"]`);
            const taskEls = container.querySelectorAll('.task-card');
            const newOrder = Array.from(taskEls).map(el => parseInt(el.getAttribute('data-task-id')));

            const inColumn = scrumConfig.tasks.filter(t => t.columnId === columnId);
            const others = scrumConfig.tasks.filter(t => t.columnId !== columnId);
            const reordered = newOrder.map(id => inColumn.find(t => t.id === id)).filter(Boolean);

            scrumConfig.tasks = [...others, ...reordered];
        }

        function updateTaskCounts() {
            scrumConfig.columns.forEach(col => {
                const count = scrumConfig.tasks.filter(t => t.columnId === col.id).length;
                const el = document.querySelector(`[data-column="${col.id}"] .task-count`);
                if (el) el.textContent = count;
            });
        }

        // Task CRUD
        function openAddTaskModal() {
            currentEditingTask = null;
            document.getElementById('modalTitle').textContent = 'Nowe zadanie';
            document.getElementById('taskForm').reset();
            document.getElementById('taskModal').classList.add('active');
        }

        function closeTaskModal() {
            document.getElementById('taskModal').classList.remove('active');
            currentEditingTask = null;
        }

        function editTask(taskId) {
            const task = scrumConfig.tasks.find(t => t.id === taskId);
            if (!task) return;

            currentEditingTask = task;
            document.getElementById('modalTitle').textContent = 'Edytuj zadanie';
            document.getElementById('taskTitle').value = task.title;
            document.getElementById('taskDescription').value = task.description;
            document.getElementById('taskPriority').value = task.priority;
            document.getElementById('taskTime').value = task.timeEstimate;
            document.getElementById('taskColumn').value = task.columnId;
            document.getElementById('taskModal').classList.add('active');
        }

        function deleteTask(taskId) {
            if (confirm('Czy na pewno chcesz usunąć to zadanie?')) {
                scrumConfig.tasks = scrumConfig.tasks.filter(t => t.id !== taskId);
                saveToJSON();
                renderBoard();
            }
        }

        function populateColumnSelect() {
            const select = document.getElementById('taskColumn');
            select.innerHTML = '';
            scrumConfig.columns.forEach(col => {
                const opt = document.createElement('option');
                opt.value = col.id;
                opt.textContent = col.name;
                select.appendChild(opt);
            });
        }

        document.getElementById('taskForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const data = {
                title: document.getElementById('taskTitle').value,
                description: document.getElementById('taskDescription').value,
                priority: document.getElementById('taskPriority').value,
                timeEstimate: parseFloat(document.getElementById('taskTime').value),
                columnId: document.getElementById('taskColumn').value
            };

            if (currentEditingTask) {
                Object.assign(currentEditingTask, data);
            } else {
                scrumConfig.tasks.push({ id: Date.now(), ...data });
            }

            saveToJSON();
            closeTaskModal();
            renderBoard();
        });

        function saveToJSON() {
            console.log('📤 Wysyłanie aktualizacji...');
            console.log(JSON.stringify(scrumConfig, null, 2));
        }

        function exportToJSON() {
            const blob = new Blob([JSON.stringify(scrumConfig, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'scrum-board-' + new Date().toISOString().slice(0,10) + '.json';
            a.click();
            URL.revokeObjectURL(url);
            alert('✅ Dane wyeksportowane!');
        }

        document.getElementById('taskModal').addEventListener('click', function(e) {
            if (e.target === this) closeTaskModal();
        });

        init();
    </script>
</body>
</html>
