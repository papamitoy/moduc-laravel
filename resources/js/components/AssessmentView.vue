<template>
  <div class="main_content_iner px-0" style="position:relative;">
    <div class="container-fluid p-0">
      <div class="row justify-content-center">
        <div class="col-lg-2 px-0 justify-content-center">
          <div class="card" id="timer-and-question">
            <div class="card-body">
              <span>Time Remaining: {{ timer }}</span>
              <hr>
              <div>

              </div>
            </div>
          </div>
        </div>

        <div class="row col-lg-8">
          <div class="col-lg-12">
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
          <div class="col-lg-12" v-for="(question,i) in   questions" :key="question.id">
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
                      <div v-for="(choice,index) in question.choices" :key="choice.choice" class="form-check">

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

          <div class="col-lg-12">
            <nav aria-label="Page navigation example">
              <button @click="submitAssessment(true)" style="width: 200px; position: absolute;" type="button" class="btn btn-primary mb-3">Submit</button>
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
        <div class="col-lg-2 px-0">

        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  props: ["assessment", "user"],
  data: () => ({
    answers: [],
    timer: "0:00",
    timer_interval: null,
    time_limit: null,
    minutes: null,
    seconds: null,
    time_expended: null,
  }),
  async mounted() {
    console.log(this.assessment);
    const timeExpended = await this.getExpendedTime();
    const timeExpendedMin = Math.floor(timeExpended / 60);
    const timeExpendedSec = timeExpended - timeExpendedMin * 60;
    this.time_expended = timeExpended;
    this.time_limit = this.assessment.time_limit;
    this.minutes = this.time_limit;

    this.seconds = 60 - timeExpendedSec == 60 ? "00" : 60 - timeExpendedSec;
    let seconds = this.seconds;
    if (this.seconds < 10 && this.seconds != "00") {
      seconds = "0" + this.seconds;
    } else {
      seconds = this.seconds;
    }

    let min = Math.floor((this.time_limit * 60 - this.time_expended) / 60);
    this.minute = min;

    if (
      this.minute <= 0 &&
      this.seconds <= 0 &&
      this.time_expended >= this.time_limit
    ) {
      this.timer = "Finished";
    } else {
      this.timer = this.minute + ":" + seconds;

      this.timer_interval = setInterval(async () => {
        if (this.timer == "Finished") return;
        if (this.minute <= 0 && this.seconds <= 0) {
          await this.saveTimer();
          this.timesUp();
          this.timer = "Finished";
          return;
        }
        if (this.seconds <= 0) {
          this.seconds = 60;
        }
        this.seconds--;
        this.time_expended++;
        if (this.seconds < 10 && this.seconds != 0) {
          seconds = "0" + this.seconds;
        } else {
          seconds = this.seconds;
        }
        let min = Math.floor((this.time_limit * 60 - this.time_expended) / 60);
        this.minute = min;
        this.timer = this.minute + ":" + seconds;
        await this.saveTimer();
      }, 1000);
    }

    console.log(this.timer);
    const that = this;
    window.onscroll = function () {
      that.scrollFunction();
    };
  },
  computed: {
    questions() {
      return JSON.parse(this.assessment.questions);
    },
  },
  methods: {
    setTimer(timer) {
      console.log(timer);
      this.timer = timer;
    },
    timesUp() {
      this.submitAssessment();
    },
    scrollFunction() {
      const header = document.getElementById("timer-and-question");

      if (window.pageYOffset > 282) {
        header.classList.add("sticky");
      } else {
        header.classList.remove("sticky");
      }
    },
    async getExpendedTime() {
      try {
        const response = await axios.post("/api/response/time-expended", {
          id: this.assessment.id,
          time_expended: this.time_expended,
        });
        if (response.data.success) {
          return response.data.data;
        }
      } catch (err) {
        return 0;
      }
    },
    async saveTimer() {
      try {
        await axios.post("/api/response/time-save", {
          id: this.assessment.id,
          time_expended: this.time_expended,
        });
      } catch (err) {}
    },
    submitAssessment(check) {
      let answerLen = Object.values(this.answers).filter(
        (answer) => answer.length > 0
      );

      if (answerLen.length < this.questions.length && check) {
        return this.$Swal.fire(
          "Warning",
          "Please answer all the questions.",
          "warning"
        );
      }

      axios
        .post("/api/assessment/response", {
          id: this.assessment.id,
          answers: { ...this.answers },
        })
        .then((res) => {
          if (res.data.success) {
            this.$Swal
              .fire("Success", "Successfully submitted", "success")
              .then(() => {
                location.reload();
              });
            return;
          }
          return this.$Swal.fire("Warning", res.data.message, "warning");
          console.log(res);
        })
        .catch((er) => {
          console.log(er);
        });
    },
  },
};
</script>

<style scoped>
.timer-and-question {
  position: absolute;
  left: 0px;
  top: 30px;
}
.sticky {
  position: fixed;
  top: 0;
  width: 13% !important;
  z-index: 10000;
}

@media (max-width: 390px) {
  .sticky {
    position: fixed;
    top: 0;
    width: 100% !important;
    z-index: 10000;
  }
}

.sticky + .content {
  padding-top: 102px;
}
</style>
