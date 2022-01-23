<template>
  <div class="messages_chat mb_30" v-if="response">
                            <div class="white_box QA_section mb_30">
                                <div class="white_box_tittle list_header">
                                    <h4>{{response.student.fullname}}</h4>
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

                                                </td>
                                                <td style="width: 600px;">
                                                    <strong>{{JSON.parse(response.answers)[question.id]}}</strong>
                                                </td>
                                                <td>
                                                    <input :value="response.score" type="text" style="background: transparent;                                                   border: none;
                                                    border-bottom: 1px solid #949494;
                                                    outline:none; font-size: 20px; -moz-appearance: textfield;
                                                    box-shadow:none; width: 50px;">
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>

                                </div>

                            </div>
                            <button style="float: right;" class="btn btn-primary">Record</button>
                        </div>
                        <div class="messages_chat mb_30" v-else>
                            <div class="white_box QA_section mb_30">
                                <div class=" ">
                                    <h4 class="text-center" style="text-alignment:center">Select a Student</h4>

                                </div>
                            </div>
                            <button style="float: right;" class="btn btn-primary">Record</button>
                        </div>
</template>

<script>
import moment from 'moment';
export default {
  props:['response','assessment'],
  data:()=>({

  }),
  computed:{
      getDate(date){
          return moment(date).format('MMMM Do YYYY, h:mm a');
      }
  }
}
</script>

<style>

</style>
