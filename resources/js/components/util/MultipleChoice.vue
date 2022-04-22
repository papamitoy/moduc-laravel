<template>
  <div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
      <div class="col-lg-12 justify-content-center">
        <div class="card_box position-relative  mb_30 white_bg ">
          <div class="box_body">
            <h5 class="">{{ number }}. {{ question.question }}</h5>
            <p class="f-w-400 ">{{ question.optional }}</p>
            <div v-for="choice in question.choices" :key="choice.choice" style="padding-top: 10px;" class="form-check">
              <input class="form-check-input" type="radio" :name="choice.choice" id="exampleRadios1" onclick="return false;" :checked="choice.correct">
              <label class="form-check-label" for="exampleRadios1">
                {{ choice.choice }} <i class="fa fa-check" v-if="choice.correct"></i>
              </label>
            </div>

          </div>
        </div>
        <div style="padding: 20px; border-top: 1px solid #f2f4ff;">
          <button @click="removeQuestion" style="background-color: #df0000e6;" class="btn btn-primary2"><i style="font-size: 15px; opacity: 1;" class="far fa-trash-alt"></i></button> |
          <button :data-target="`#msModal${question.id}`" data-toggle="modal" class="btn btn-primary2"><i style="font-size: 15px; opacity: 1;" class="far fa-edit"></i></button>
        </div>
      </div>
    </div>
    <!-- Modal mc-->
    <div data-backdrop="false" class="modal" :id="`msModal${question.id}`" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div style="z-index: 10000;" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="form-row align-items-center">
              <div style="width: 100%;" class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Question</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>
              <div class="col-auto">
                <label class="sr-only" for="inlineFormInputGroup"></label>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="answer here..">
                </div>
              </div>
              <div class="col-auto">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="autoSizingCheck">
                  <label class="form-check-label" for="autoSizingCheck">
                    Correct Answer
                  </label>
                </div>
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-primary2 mb-2">Add</button>
              </div>
            </div>
            <div>
              <form style="font-size: 17px;" class="form-check">
                <div style="padding-bottom: 5px; color: #00C3FF;" class="form-check">
                  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="d">
                  <a style="padding: 2px 5px; font-size: 10px; background-color: red; border-color: red;" class="btn btn-primary" href=""><i class="far fa-trash-alt"></i></a>
                </div>
                <div style="padding-bottom: 5px; color: #00C3FF;" class="form-check">
                  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="d">
                  <a style="padding: 2px 5px; font-size: 10px; background-color: red; border-color: red;" class="btn btn-primary" href=""><i class="far fa-trash-alt"></i></a>
                </div>
                <div style="padding-bottom: 5px; color: #00C3FF;" class="form-check">
                  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="d">
                  <a style="padding: 2px 5px; font-size: 10px; background-color: red; border-color: red;" class="btn btn-primary" href=""><i class="far fa-trash-alt"></i></a>
                </div>
                <div style="padding-bottom: 5px; color: #00C3FF;" class="form-check">
                  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="d">
                  <a style="padding: 2px 5px; font-size: 10px; background-color: red; border-color: red;" class="btn btn-primary" href=""><i class="far fa-trash-alt"></i></a>
                </div>

              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal MC end-->
  </div>
</template>

<script>
export default {
  props: ["question", "number"],
  methods: {
    removeQuestion() {
      this.$emit("removeQuestion", this.question);
    },
  },
};
</script>

<style>
</style>
