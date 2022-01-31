<template>
  <div class="col-lg-12">
    <div class="messages_box_area">
      <div class="messages_list">
        <div class="white_box ">
          <div class="white_box_tittle list_header">
            <h4>Student Response List</h4>
          </div>
          <ul>
            <li v-for="response in responses" :key="response.id" @click="selectStudent(response)">
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
                  <span style="background-color: green; padding: 2px; color: white; border-radius: 2px;" class="text-succes" v-if="response.status"> Recorded </span>
                  <span style="background-color: green; padding: 2px; color: white; border-radius: 2px;" class="text-succes" v-else> Pending </span>
                </div>
              </a>
            </li>
          </ul>
        </div>

      </div>
      <SelectedAssessment :response="selectedStudent" :assessment="assessment" />
    </div>
  </div>
</template>

<script>
import SelectedAssessment from "./util/SelectedAssessment.vue";
export default {
  props: ["students", "responses", "assessment"],
  data: () => ({
    selectedStudent: null,
    hasUserId: false,
  }),
  components: {
    SelectedAssessment,
  },
  watch: {
    hasUserId() {
      const student = this.responses.find(
        (student) => student.user_id == this.hasUserId
      );
      this.selectStudent(student ? student : null);
    },
  },
  async mounted() {
    let uri = window.location.search;
    let params = new URLSearchParams(uri);
    console.log(this.responses);
    if (params.get("user_id")) {
      this.hasUserId = params.get("user_id");
    }
  },
  methods: {
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
