<template>
  <div class="">
    <div class="messages_chat mb_30">
      <div class="white_box QA_section mb_30">
        <div class="white_box_tittle list_header">
          <h2>{{assessment.title}}</h2>
        </div>
        <div class="white_box_tittle list_header">
          <h4> Reymond</h4>
          <div class="box_right d-flex lms_block">
            <div class="serach_field_2">
              <p>Submitted on: {{getDate(getStudentResponse().created_at,"lll")}}</p>
            </div>
          </div>
        </div>

        <div class=" ">
          <!-- table-responsive -->
          <table class="table " style="width:100%;">
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
                <td style="width: 200px;">
                  <p class="">{{ question.question }}</p>
                </td>
                <td style="color: green;">
                  <strong v-if="question.type == 'multiple-choice' && question.choices[0].correct">{{ question.choices[0].choice }}</strong>
                  <strong v-if="question.type == 'short-answer'">{{question.correctAnswer}}</strong>
                </td>
                <td style="width: 200px;">
                  <strong>{{ getStudentResponse() &&  JSON.parse(getStudentResponse().answers)[question.id] }}</strong>
                </td>
                <td>{{ question.points }}</td>
                <td>
                  <strong>{{ getStudentResponse() &&  getStudentResponse().score && JSON.parse(getStudentResponse().score)[question.id] }}</strong>
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
    </div>
  </div>
</template>

<script>
import moment from "moment";
export default {
  props: ["assessment", "user_id"],
  mounted() {
    console.log("THIS ASSESSMENT", this.assessment);
  },
  computed: {
    totalScore() {
      const response = this.getStudentResponse();
      if (response && response.score) {
        const score = Object.values(JSON.parse(response.score)).reduce(
          (result, item) => result + item,
          0
        );
        return score;
      }
      return 0;
    },
  },
  methods: {
    getDate(date, format) {
      return moment(date).format(format);
    },
    getStudentResponse() {
      const response = this.assessment.response.find(
        (res) => res.user_id == this.user_id
      );
      if (response) {
        return response;
      }
      return null;
    },
  },
};
</script>

<style>
</style>
