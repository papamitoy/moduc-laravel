<template>

  <div class="col-md-8 col-lg-8 col-xl-6 box-col-8">
    <div class="white_card card_height_100 mb_30">
      <div class="white_card_header">
        <div class="box_header m-0">
          <div class="main-title">
            <h3 class="m-0">Preview</h3>
          </div>
        </div>
      </div>
      <div class="white_card_body">
        <div class="card-body">
          <h1>{{ title }}</h1>
          <h5>{{ description }}</h5>
          <p></p>

          <div style="padding-bottom: 20px;" class="form-row">
            <small>This is only a Preview..</small>
          </div>
          <div ref="assessmentContainer">
            <!-- <div style="padding-bottom: 20px;" class="form-group">
              <h6>3. What is your name:</h6>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                <label class="form-check-label" for="exampleRadios1">
                  Default radio
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                <label class="form-check-label" for="exampleRadios1">
                  Default radio
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                <label class="form-check-label" for="exampleRadios1">
                  Default radio
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                <label class="form-check-label" for="exampleRadios1">
                  Default radio
                </label>
              </div>
            </div> -->

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 col-lg-4 col-xl-6 box-col-4">
    <div class="white_card card_height_100 mb_30">
      <div class="white_card_header">
        <div class="box_header m-0">
          <div class="main-title">
            <h3 class="m-0">Create Questioner</h3>
          </div>
        </div>
      </div>
      <div class="white_card_body">
        <div class="card-body">

          <div class="form-group">
            <label for="inputAddress">Form Title</label>
            <input v-model="title" style="font-size: 25px;" type="text" class="form-control" id="inputAddress" placeholder="Untitled Form">
          </div>
          <div class="form-group">
            <label for="inputAddress">Form Description</label>
            <input v-model="description" style="font-size: 15px;" type="text" class="form-control" id="inputAddress" placeholder="Description">
          </div>

          <div class="form-row">

            <div class="form-group col-md-4">
              <label for="inputState">Questioner Type</label>
              <select v-model="selectQuestionType" id="inputState" class="form-control">
                <option value="e" selected>Essay</option>
                <option value="mc">Multiple Choice</option>
                <option value="sa">Short Answer</option>
              </select>

            </div>

          </div>

          <div v-if="selectQuestionType == 'sa'">
            <div class="form-group">
              <label for="inputAddress">Question</label>
              <textarea ref="shortAnswerQuestion" v-model="question" class="form-control" id="shortAnswerQuestion" placeholder="Your Question here.."></textarea>
              <small v-if="questionError" class="text-danger"><i>You need to fillup the question</i></small>
            </div>
            <div class="form-group">
              <label for="inputAddress">Answer</label>
              <textarea class="form-control" id="inputAddress" placeholder="Essay Answer"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" @click="createShortAnswer">Submit</button>
          </div>

          <div v-else-if="selectQuestionType == 'e'">
            <div class="form-group">
              <label for="inputAddress">Question {{ questionCounter}}</label>
              <textarea ref="essayQuestion" v-model="questionEssay" class="form-control" id="inputAddress" placeholder="Your Question here.."></textarea>
              <small v-if="questionEssayError" class="text-danger"><i>You need to fillup the question</i></small>
            </div>
            <div class="form-group">
              <label for="inputAddress">Answer</label>
              <textarea class="form-control" id="inputAddress" placeholder="Essay Answer"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" @click="createEssay">Submit</button>
          </div>

          <div v-else>

            <div class="form-group">
              <label for="inputAddress">Question</label>
              <textarea ref="mcQuestion" v-model="questionMC" class="form-control " id="inputAddress" placeholder="Your Question here.."></textarea>
              <small v-if="questionMCError" class="text-danger"><i>You need to fillup the question</i></small>
            </div>
            <div class="form-group">
              <div>
                <label for="inputAddress">Answer</label>
                <div>
                  <input ref="addchoice" type="text" v-model="choice">
                  <small v-if="choiceError" class="text-danger"><i>You need to fillup the question</i></small>
                </div>
                <input type="checkbox" v-model="isAnswer" name="isAnswer">
                <label for="isAnswer">is Answer</label>
                <button @click="addChoice">Add</button>
              </div>

              <div v-for="choice in choices" :key="choice" class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                <label class="form-check-label" for="exampleRadios1">
                  {{ choice.choice }}
                </label>
              </div>

            </div>
            <button type="submit" class="btn btn-primary" @click="createMC">Submit</button>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    title: "",
    description: "",
    selectQuestionType: "e",

    question: "",
    questionEssay: "",
    questionMC: "",
    questionCounter: 1,

    questions: [],
    choices: [],
    choice: "",
    isAnswer: false,

    questionError: false,
    questionEssayError: false,
    questionMCError: false,
    choiceError: false,
  }),
  watch: {
    selectQuestionType() {
      this.clearErrors();
    },
  },
  methods: {
    addChoice() {
      if (this.choice == "") {
        this.$refs.addchoice.classList.add("is-invalid");
        this.choiceError = true;
        return;
      }
      let choice = {
        choice: this.choice,
        isAnswer: this.isAnswer,
      };
      this.choices.push(choice);
    },

    clearErrors() {
      this.questionError = false;
      this.questionEssayError = false;
      this.questionMCError = false;
      this.choiceError = false;
    },
    createQuestion() {
      if (this.selectQuestionType == "e") {
        let question = {
          question: this.questionEssay,
        };
        this.questions.push(question);
      } else if (this.selectQuestionType == "mc") {
        let question = {
          question: this.questionMC,
          choices: this.choices,
        };
        this.questions.push(question);
      } else if (this.selectQuestionType == "sa") {
        let question = {
          question: this.question,
        };
        this.questions.push(question);
      }
    },
    createShortAnswer() {
      if (this.question == "") {
        this.$refs.shortAnswerQuestion.classList.add("is-invalid");
        this.questionError = true;
        return;
      }
      this.createQuestion();
      //  <div style="padding-bottom: 20px;" class="form-group">
      //     <h6>1. What is your name:</h6>
      //     <p style="border-bottom: 2px solid black; ">Your answer</p>
      //   </div>
      let questionContainer = document.createElement("div");
      questionContainer.style.paddingBottom = "20px";
      questionContainer.classList.add("form-group");
      let question = document.createElement("h6");
      question.innerText = this.questionCounter++ + ". " + this.question;
      let answer = document.createElement("p");
      answer.innerText = "Your Answer";
      answer.style.borderBottom = "2px solid black";
      questionContainer.appendChild(question);
      questionContainer.appendChild(answer);
      this.$refs.assessmentContainer.appendChild(questionContainer);
    },
    createEssay() {
      if (this.questionEssay == "") {
        this.$refs.essayQuestion.classList.add("is-invalid");
        this.questionEssayError = true;
        return;
      }
      this.createQuestion();
      console.log("awdawd");
      let questionContainer = document.createElement("div");
      questionContainer.style.paddingBottom = "20px";
      questionContainer.classList.add("form-group");
      let question = document.createElement("h6");
      question.innerText = this.questionCounter++ + ". " + this.questionEssay;
      let answer = document.createElement("p");
      answer.innerText = "Paragraph";
      answer.style.borderBottom = "2px solid black";
      questionContainer.appendChild(question);
      questionContainer.appendChild(answer);
      this.$refs.assessmentContainer.appendChild(questionContainer);
    },
    createMC() {
      if (this.questionMC == "") {
        this.$refs.mcQuestion.classList.add("is-invalid");
        this.questionMCError = true;
        return;
      }

      this.createQuestion();
      // <div class="form-check">
      //         <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
      //         <label class="form-check-label" for="exampleRadios1">
      //           Default radio
      //         </label>
      //       </div>

      console.log("awdawd");
      let questionContainer = document.createElement("div");
      questionContainer.style.paddingBottom = "20px";
      questionContainer.classList.add("form-group");
      let question = document.createElement("h6");
      question.innerText = this.questionCounter++ + ". " + this.questionMC;
      questionContainer.appendChild(question);

      this.choices.map((choice) => {
        let answerContainer = document.createElement("div");
        if (choice.isAnswer) {
          answerContainer.style.backgroundColor = "green";
        }
        let answerInput = document.createElement("input");
        answerInput.type = "radio";
        answerInput.name = choice.choice;

        let answerLabel = document.createElement("label");
        answerLabel.setAttribute("for", choice.choice);
        answerLabel.innerText = choice.choice;
        answerContainer.appendChild(answerInput);
        answerContainer.appendChild(answerLabel);
        questionContainer.appendChild(answerContainer);
      });

      this.$refs.assessmentContainer.appendChild(questionContainer);
    },
  },
};
</script>

<style>
</style>
