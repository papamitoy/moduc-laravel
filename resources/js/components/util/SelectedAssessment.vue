<template>
  <div class="messages_chat mb_30" v-if="!!response">
    <div class="white_box QA_section mb_30">
      <div class="white_box_tittle list_header">
        <h4>{{ response.student.fullname }}</h4>
        <div class="box_right d-flex lms_block">
          <div class="serach_field_2">
            <p>{{ getDate }}</p>
          </div>
        </div>
      </div>

      <div class="QA_table ">
        <!-- table-responsive -->
        <table class="table lms_table_active">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Question</th>
              <th scope="col">Correct Answer</th>
              <th scope="col">Student Answer</th>
              <th scope="col">Max Points</th>
              <th style="width: 30px;" scope="col">Score</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(question,index) in JSON.parse(assessment.questions)" :key="question.id">
              <td>
                <p>{{ index+1 }}.</p>
              </td>
              <td style="width: 600px;">
                <p class="">{{ question.question }}</p>
              </td>
              <td style="color: green;">
                <strong v-if="question.type == 'multiple-choice' && question.choices[0].correct">{{ question.choices[0].choice }}</strong>
                <strong v-if="question.type == 'short-answer'">{{question.correctAnswer}}</strong>
              </td>
              <td style="width: 600px;">
                <strong>{{JSON.parse(response.answers)[question.id]}}</strong>
              </td>
              <td>{{ question.points }}</td>
              <td>
                <input @input="(e)=>{onKeydown(question.points, question.id)}" :max="question.points" min="0" :name="question.id" v-model="scoreArray[question.id]" type="number" style="background: transparent;                                                   border: none;
                                                    border-bottom: 1px solid #949494;
                                                    outline:none; font-size: 20px; -moz-appearance: textfield;
                                                    box-shadow:none; width: 50px;">
              </td>
            </tr>

          </tbody>
          <tfoot>
            <tr>
              <td colspan="3"></td>

              <td colspan="2" style="text-align:right"> <span style="margin-right:10px">TOTAL:</span> <b>{{ totalScore  }}</b></td>
            </tr>
          </tfoot>
        </table>

      </div>

    </div>

    <button style="float: right;" class="btn btn-primary" @click="recordScore">Record</button>
    <a :href="`/subject/${assessment.subject_id}/grades`" style="float: right;" class="btn btn-primary mr-2">Class Record</a>
  </div>
  <div class="messages_chat mb_30" v-else>
    <div class="white_box QA_section mb_30">
      <div class=" ">
        <h4 class="text-center" style="text-alignment:center">Select a Student</h4>

      </div>
    </div>
    <a :href="`/subject/${assessment.subject_id}/grades`" style="float: right;" class="btn btn-primary">Class Record</a>
  </div>
</template>

<script>
import moment from "moment";
import { toRaw, isProxy } from "vue";
export default {
  props: ["response", "assessment"],
  data: () => ({
    scoreArray: [],
  }),
  mounted() {},
  watch: {
    response() {
      if (!this.response.score) {
        console.log("CHECK SCORE", this.response.score);
        return this.autoChecker();
      }
      console.log("response updated", this.response.score);
      this.scoreArray = JSON.parse({ ...this.response }.score);
    },
  },
  computed: {
    getDate(date) {
      return moment(date).format("MMMM Do YYYY, h:mm a");
    },

    totalScore() {
      if (!this.scoreArray) return 0;
      return Object.values(this.scoreArray).reduce((cscore, score) => {
        return cscore + Number(score);
      }, 0);
    },
  },
  methods: {
    onKeydown(max, id) {
      this.scoreArray[id] =
        this.scoreArray[id] > max ? max : this.scoreArray[id];

      this.scoreArray[id] = this.scoreArray[id] < 0 ? 0 : this.scoreArray[id];
    },
    autoChecker() {
      JSON.parse(this.assessment.questions).map((question) => {
        if (question.type == "short-answer") {
          if (
            question.correctAnswer &&
            question.correctAnswer.toLowerCase() ==
              JSON.parse(this.response.answers)[question.id].toLowerCase()
          ) {
            this.scoreArray[question.id] = question.points || 1;
          } else {
            this.scoreArray[question.id] = 0;
          }
        } else if (
          question.type == "multiple-choice" &&
          question.choices[0].correct
        ) {
          this.scoreArray[question.id] =
            JSON.parse(this.response.answers)[question.id] ==
            question.choices[0].choice
              ? question.points || 1
              : 0;
        } else {
          this.scoreArray[question.id] = "";
        }
      });
      return this.scoreArray;
    },
    recordScore() {
      console.log({ ...this.scoreArray });
      axios
        .post("/api/assessment/save/record", {
          submission_id: this.response.id,
          assessment_id: this.assessment.id,
          score: { ...this.scoreArray },
          subject_id: this.assessment.subject_id,
        })
        .then((res) => {
          if (res.data.success) {
            this.$emit("recorded", this.response);
            return this.$Swal.fire(
              "Success",
              "Recorded successfully.",
              "success"
            );
          }
          return this.$Swal.fire(
            "Warning",
            "Try again, Please try again.",
            "warning"
          );
        })
        .catch((err) => console.log(err));
      console.log(this.totalScore);
    },
  },
};
</script>

<style>
</style>
