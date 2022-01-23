<template>
  <div class="main_content_iner ">
    <div class="container-fluid p-0">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="white_card card_height_100 mb_30">
            <div class="col-lg-12 justify-content-center">
              <div class="card_box position-relative  mb_30 white_bg ">
                <div class="white_box_tittle     ">
                  <div class="main-title2 ">
                    <h1 class="mb-2 nowrap ">{{assessment.title}}</h1>
                    <smal>{{ assessment.description }}</smal>
                  </div>
                </div>
                <div style="padding-bottom: 40px; padding-top: 20px; position: relative;" class="box_body">

                  <p class="f-w-400 "></p><strong>{{ user.email }} <span style="font-weight: 100;">(not shared)</span></strong>

                  <a style="position: absolute;" href="#"> Switch account</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8" v-for="(question,i) in   questions" :key="question.id">
          <div class="white_card card_height_100 mb_30">
            <div class="col-lg-12 justify-content-center">
              <div class="card_box position-relative  mb_30 white_bg ">
                <div class="box_body">
                  <h5 class="">{{i+1}}. {{ question.question }}</h5>
                  <p class="f-w-400 ">{{ question.optional }}</p>
                  <div v-if="question.type != 'multiple-choice'">

                  <input v-model="answers[question.id]" type="text" style="border: 0; outline: 0; border-bottom: 1px solid #03a8f45e; font-size: 1rem;  color: #000; width: 50%; padding-top: 15px;" placeholder="Your Answer">
                  </div>
                  <div v-else>
                <div v-for="(choice,index) in question.choices" :key="choice.choice"  class="form-check">

                    <input v-model="answers[question.id]" class="form-check-input" type="radio" :name="question.id" :id="question.id +'_'+ index" :value="choice.choice">
                    <label class="form-check-label" :for="question.id +'_'+ index">
                      {{choice.choice}}
                    </label>

                </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-8">
          <nav aria-label="Page navigation example">
            <button @click="submitAssessment" style="width: 200px; position: absolute;" type="button" class="btn btn-primary mb-3">Submit</button>
            <ul class="pagination justify-content-end">
              <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">Next</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
    props:['assessment','user'],
    data:()=>({
        answers:[]
    }),
    mounted(){
        console.log(this.assessment)
    },
    computed:{
        questions(){
            return JSON.parse(this.assessment.questions)
        }
    },
    methods:{
        submitAssessment(){
            let answerLen = Object.values(this.answers).filter(answer => answer.length > 0)
            if(answerLen.length < this.questions.length){
               return this.$Swal.fire(
                "Warning",
                "Please answer all the questions.",
                "warning"
                );
            }
            console.log({...this.answers})

            axios.post("/api/assessment/response",{
                id:this.assessment.id,
                answers:{...this.answers}
            }
            ).then(res=>{
                console.log(res);
            }).catch(er=>{
                console.log(er)
            })

        }
    }
};
</script>

<style>
</style>
