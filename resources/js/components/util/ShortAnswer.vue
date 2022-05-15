<template>

  <div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
      <div class="col-lg-12 justify-content-center">
        <div class="card_box position-relative  mb_30 white_bg ">
          <div class="box_body ">
            <div class="flex">
              <h5 class="">{{ number }}. {{ question.question }}</h5>
              <div>{{question.points}} pts.</div>
            </div>
            <p class="f-w-400 ">{{ question.optional }}</p>
            <input type="text" :value="question.correctAnswer" readonly style="border: 0; outline: 0; border-bottom: 1px solid #03a8f45e; font-size: 1rem;  color: #000; width: 50%; padding-top: 15px;" placeholder="Your Answer">

          </div>
          <div style="padding: 20px; border-top: 1px solid #f2f4ff;" v-if="enableEdit">
            <button @click="removeQuestion" style="background-color: #df0000e6;" class="btn btn-primary2"><i style="font-size: 15px; opacity: 1;" class="far fa-trash-alt"></i></button> |
            <button :data-target="`#saModal${question.id}`" data-toggle="modal" class="btn btn-primary2"><i style="font-size: 15px; opacity: 1;" class="far fa-edit"></i></button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 3-->
    <div data-backdrop="false" class="modal fade" :id="`saModal${question.id}`" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div style="z-index: 10000 !important" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="mb-3">
              <label for="exampleFormControlTextarea1" class="form-label">Question</label>
              <textarea v-model="equestion" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label for="">Points</label>
              <input class="form-control" type="number" v-model="points" placeholder="Points">
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Answer</label>
              <input v-model="ecorrectAnswer" class="form-control" id="exampleFormControlInput1">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button @click="saveChanges" type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal 3 end-->
  </div>

</template>

<script>
export default {
  props: ["question", "number", "enableEdit"],
  data: () => ({
    ecorrectAnswer: "",
    equestion: "",
    points: "",
  }),
  mounted() {
    this.ecorrectAnswer = this.question.correctAnswer;
    this.equestion = this.question.question;
    this.points = this.question.points;
  },
  methods: {
    removeQuestion() {
      this.$emit("removeQuestion", this.question);
    },
    saveChanges() {
      this.$emit("updateQuestion", {
        oldQuestion: this.question,
        newQuestion: {
          ...this.question,
          question: this.equestion,
          correctAnswer: this.ecorrectAnswer,
          points: this.points,
        },
      });
    },
  },
};
</script>

<style scoped>
.flex {
  display: flex;
  justify-content: space-between;
}
</style>
