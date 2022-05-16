<template>
  <table class="table lms_table_active">
    <thead>

      <tr>
        <th scope="col">

        </th>
        <th scope="col"></th>
        <th scope="col">Name</th>

        <th scope="col">Details</th>
        <th scope="col">Email</th>
        <th scope="col">Action</th>

      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row"></th>
        <td> <i class="fas fa-chalkboard-teacher"></i> </td>
        <td>
          <div class="media align-items-center">
            <img class="circle-rounded mr-3" src="pages/img/messages/1.png" alt="" width="30" height="30">
            <div class="">
              <p>{{ adviser.fullname }}</p>
            </div>
          </div>
        </td>
        <td>
          Adviser
        </td>

        <td>
          <p class="">{{ adviser.email }}</p>
        </td>
        <td>

        </td>
      </tr>

      <tr v-for="(student,i) in studentList" :key="i">
        <th scope="row">
        </th>
        <td> <i class="fas fa-user-alt"></i> </td>
        <td>
          <div class="media align-items-center">
            <img class="circle-rounded mr-3" src="pages/img/messages/1.png" alt="" width="30" height="30">
            <div class="">
              <p>{{student.student.fullname }}</p>
            </div>
          </div>
        </td>
        <td>
          <p> Student</p>
        </td>
        <td>
          <p class="">
            {{ student.student.email }}</p>
        </td>
        <td>
          <button v-if="is_adviser" class="btn btn-danger" @click="removeStudent(student)">remove</button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: ["students", "adviser", "is_adviser"],
  data: () => ({
    studentList: [],
  }),
  mounted() {
    this.studentList = this.students;
  },
  methods: {
    async removeStudent(student) {
      try {
        this.$Swal
          .fire({
            title: "Do you want to remove this student?",
            showCancelButton: true,
            confirmButtonText: "Yes",
          })
          .then(async (result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              const response = await axios.post("/api/subject/removestudent", {
                id: student.id,
              });
              if (response.data.success) {
                this.studentList = this.studentList.filter(
                  (stud) => stud.id != student.id
                );
              } else {
                this.$Swal.fire("Remove!", "", "warning");
              }
            }
          });
      } catch (err) {}
    },
  },
};
</script>

<style>
</style>
