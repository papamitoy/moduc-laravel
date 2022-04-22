<template>
  <div class="col-lg-12">

    <h3 class="f_s_25 f_w_700 dark_text mb-2">{{ subject.subject_name }} : {{ assessment.title }}</h3>

    <div class="messages_box_area">
      <div class="messages_list">
        <div class="white_box ">
          <div class="white_box_tittle list_header">
            <h4>Student Response List</h4>
          </div>
          <ul>
            <li v-for="response in studentList" :key="response.id" @click="selectStudent(response)">
              <a href="#">
                <div class="message_pre_left">
                  <div class="message_preview_thumb">
                    <img src="img/messages/1.png" alt="">
                  </div>
                  <div class="messges_info">
                    <h4>{{ response.student.fullname }}</h4>
                    <p>{{response.student.email}}</p>
                  </div>
                </div>
                <div class="messge_time">
                  <span class="text-white badge bg-success" v-if="response.status"> Recorded </span>
                  <span class="text-white badge bg-warning" v-else> Pending </span>
                </div>
              </a>
            </li>
          </ul>
        </div>

      </div>
      <SelectedAssessment @recorded="setRecorded" :response="selectedStudent" :assessment="assessment" />
    </div>
  </div>
</template>

<script>
import SelectedAssessment from "./util/SelectedAssessment.vue";
export default {
  props: ["students", "responses", "assessment", "subject"],
  data: () => ({
    selectedStudent: null,
    hasUserId: false,
    studentList: [],
  }),
  components: {
    SelectedAssessment,
  },
  watch: {
    hasUserId() {
      const student = this.studentList.find(
        (student) => student.user_id == this.hasUserId
      );
      this.selectStudent(student ? student : null);
    },
    responses() {
      this.studentList = this.responses;
    },
  },
  async mounted() {
    this.studentList = this.responses;
    let uri = window.location.search;
    let params = new URLSearchParams(uri);
    if (params.get("user_id")) {
      this.hasUserId = params.get("user_id");
    }
  },
  methods: {
    setRecorded(val) {
      this.studentList = this.studentList.map((student) => {
        console.log(student.id, val.id);
        if (student.id == val.id) {
          student.status = 1;
        }
        return student;
      });
    },
    selectStudent(student) {
      console.log("STUDENT", student);
      this.selectedStudent = student;
      let uri = window.location.search;
      let params = new URLSearchParams(uri);
      params.set("user_id", student.id);
      params.append("person", "Tim");
    },
  },
};
</script>

<style>
</style>
