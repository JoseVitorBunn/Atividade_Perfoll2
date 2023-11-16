<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container" id="app">
        <h1 class="text-center mt-4">Gerenciador de Tarefas</h1>
        <h2 class="text-center mt-2">Bem-vindo ao Gerenciador de Tarefas</h2>

        <div class="form-group">
            <input type="text" class="form-control" v-model="newTask.name" placeholder="Digite a tarefa">
            <input type="date" class="form-control" v-model="newTask.dueDate" placeholder="Data de Vencimento">
            <small class="form-text text-muted">Digite a tarefa, escolha a data de vencimento e clique em "Adicionar Tarefa".</small>
        </div>

        <button class="btn btn-primary" @click="addTask">Adicionar Tarefa</button>
        <small class="form-text text-muted">Clique no botão para adicionar a tarefa à lista.</small>

        <ul class="list-group mt-4">
            <li class="list-group-item" v-for="(task, index) in tasks" :key="index">
                <span :class="{ 'task-completed': task.completed }">{{ task.name }} ({{ task.dueDate }})</span>
                <button class="btn btn-success btn-sm float-right" @click="completeTask(index)">Concluir</button>
                <button class="btn btn-danger btn-sm float-right" @click="deleteTask(index)">Excluir</button>
                <button class="btn btn-warning btn-sm float-right" @click="editTask(index)">Editar</button>
            </li>
        </ul>

        <!-- Seção para Tarefas Concluídas -->
        <h2 class="text-center mt-4">Tarefas Concluídas</h2>
        <ul class="list-group mt-4">
            <li class="list-group-item" v-for="(completedTask, index) in completedTasks" :key="index">
                {{ completedTask.name }} ({{ completedTask.dueDate }}) - Concluída em {{ completedTask.completedDate }}
            </li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                newTask: { name: '', dueDate: '' },
                tasks: [],
                completedTasks: [],
                checkedTasks: []
            },
            methods: {
                addTask() {
                    this.tasks.push({ name: this.newTask.name, dueDate: this.newTask.dueDate, completed: false });
                    this.newTask = { name: '', dueDate: '' };
                    this.saveTasks();
                    alert('Tarefa adicionada com sucesso!');
                },
                deleteTask(index) {
                    this.tasks.splice(index, 1);
                    this.saveTasks();
                    alert('Tarefa excluída com sucesso!');
                },
                completeTask(index) {
                    this.tasks[index].completed = true;
                    this.tasks[index].completedDate = new Date().toLocaleString();
                    this.completedTasks.push(this.tasks[index]);
                    this.tasks.splice(index, 1);
                    this.saveTasks();
                    alert('Tarefa concluída com sucesso!');
                },
                editTask(index) {
                    const editedTask = prompt('Digite a nova descrição da tarefa:', this.tasks[index].name);
                    if (editedTask !== null) {
                        this.tasks[index].name = editedTask;
                        this.saveTasks();
                        alert('Tarefa editada com sucesso!');
                    }
                },
                saveTasks() {
                    localStorage.setItem('tasks', JSON.stringify(this.tasks));
                    localStorage.setItem('completedTasks', JSON.stringify(this.completedTasks));
                }
            },
            created() {
                const storedTasks = localStorage.getItem('tasks');
                if (storedTasks) {
                    this.tasks = JSON.parse(storedTasks);
                }

                const storedCompletedTasks = localStorage.getItem('completedTasks');
                if (storedCompletedTasks) {
                    this.completedTasks = JSON.parse(storedCompletedTasks);
                }
            }
        });
    </script>
</body>
</html>
