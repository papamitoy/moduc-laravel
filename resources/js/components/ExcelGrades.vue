<template>

  <div class="main_content_iner ">
    <div class="container-fluid p-0">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="white_card card_height_100 mb_30">

            <div class="white_card_header">
              <div class="bulder_tab_wrapper">
                <ul class="nav justify-content-center" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a :class="`nav-link active`" id="Themes-tab" data-toggle="tab" :href="`#midterm`" role="tab" aria-controls="Themes" aria-selected="true">Midterm</a>
                  </li>
                  <li class="nav-item">
                    <a :class="`nav-link`" id="Themes-tab" data-toggle="tab" :href="`#final`" role="tab" aria-controls="Themes" aria-selected="true">Finals</a>
                  </li>

                </ul>

              </div>
            </div>
            <div class="white_card_body">
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="midterm" role="tabpanel" aria-labelledby="Themes-tab">
                  <SectionGrades :title="`Midterm`" :subject="subject" :module_section="module_section" />
                </div>

                <div :class="`tab-pane fade`" id="final" role="tabpanel" aria-labelledby="Themes-tab">
                  <SectionGrades :title="`Final`" :subject="subject" :module_section="module_section" />
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="col-12">

        </div>
      </div>
    </div>
  </div>

</template>

<script>
import SectionGrades from "./util/SectionGrades.vue";
export default {
  props: ["subject", "module_section"],
  components: {
    SectionGrades,
  },
  methods: {},
};
</script>

<style>
.rgHeaderCell {
  border-right: 1px solid rgba(0, 0, 0, 0.2);
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type="number"] {
  -moz-appearance: textfield;
}
</style>
