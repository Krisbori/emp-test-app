<template>
  <div class="container">
    <div>
      <div div class="card text-end">
        <div class="card-body">
          <button class="btn btn-sm btn-primary" v-on:click="showAddModalForm()">Добавить сотрудника</button>
        </div>    
      </div>
      <div class="card">
        <div class="card-body">
          <table class="table table-sm table-hover">
            <thead>
              <tr>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчетсво</th>
                <th>Должность</th>
                <th>Дата приема</th>
                <th>ЗП</th>
                <th>Действие</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="employee in employees" :key="employee.id">
                <td>{{ employee.surname }}</td>
                <td>{{ employee.name }}</td>
                <td>{{ employee.patronymic }}</td>
                <td>{{ employee.position }}</td>
                <td>{{ employee.recruitment_date }}</td>
                <td>{{ employee.salary }}</td>
                <td>
                  <button class="btn btn-sm btn-success" v-on:click="showEditModalForm(employee)">Изменить</button>
                  <button class="btn btn-sm btn-danger" v-on:click="deleteEmployee(employee.id)">Удалить</button>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- Modal -->
          <form class="was-validated" v-on:submit.prevent="isEditMode ? updateEmployee() : addEmployee()">
            <div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" v-show="!isEditMode">Добавление сотрудника</h5>
                    <h5 class="modal-title" v-show="isEditMode">Редактирование сотрудника</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                <div class="modal-body">
                  <div class="form-floating mb-3">
                    <input class="form-control" type="text"  id="inputSurname" placeholder="Фамилия" v-model="employee.surname" required>
                    <label for="inputSurname">Фамилия</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="text" id="inputName" placeholder="Имя" v-model="employee.name" required>
                    <label for="inputName">Имя</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="text" id="inputPatronymic" placeholder="Отчество" v-model="employee.patronymic" required>
                    <label for="inputPatronymic">Отчество</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="text" id="inputPosition" placeholder="Должность"  v-model="employee.position" required>
                    <label for="inputPosition">Должность</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="date" id="inputRecDate" v-model="employee.recruitment_date" placeholder="Дата приема" required>
                    <label for="inputRecDate">Дата приема</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="number" id="inputSalary" placeholder="Размер ЗП"  v-model="employee.salary" required>
                    <label for="inputSalary">Размер ЗП</label>
                  </div>
                  <div class="form-floating mb-3">
                    <select  class="form-select" id="selectBoss" v-model="employee.employee_id" required> 
                      <option disabled value="">Выберите руководителя</option>
                      <option v-for="empSelect in employees" :key="empSelect.id" v-bind:value="empSelect.id">
                        {{ empSelect.surname }}   {{ empSelect.name }}  {{ empSelect.patronymic }}
                      </option>
                    </select>
                    <label for="selectBoss">Руководитель</label>
                  </div>
                 </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary" v-show="!isEditMode">Добавить</button>
                    <button type="submit" class="btn btn-primary" v-show="isEditMode">Сохранить</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <!-- End Modal -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>


export default {
  data() {
    return {
      isEditMode: false,
      employee: {},
      employees: [],
    };
  },
  methods: {
    loadEmployeesList(){
        axios.get("/api/list").then((response) => {
          this.employees = response.data;
        });
    },
    showEditModalForm(employee){
        this.isEditMode = true;
          $('#newModal').modal('show');
          this.employee = JSON.parse(JSON.stringify(employee));
    },
    showAddModalForm(){
        this.isEditMode = false;
         $('#newModal').modal('show');
         this.employee = {
           employee_id: ''
         };
    },   
    deleteEmployee(id) {
      axios.delete("/api/employees/" + id)
        .then(()=>{
          this.loadEmployeesList();
      });
    },
    addEmployee() {
      axios
        .post('/api/employees', this.employee)
          .then(() => {
            $('#newModal').modal('hide');
            this.loadEmployeesList();
            }); 
    },
    updateEmployee() {
        axios.patch('/api/employees/'+this.employee.id, this.employee)
            .then(() => {
                $('#newModal').modal('hide');
                this.loadEmployeesList();
                    });
    }
  },
   mounted() {

  },
  created() {
    this.loadEmployeesList();
  }
};
</script>