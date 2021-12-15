<template>
  <div class="col-lg-5">

    <div class="disabled card_box box_shadow position-relative mb_30">
      <div @mouseenter="showBtn =true" v-if="active == 0" class="overlay-section disabled">
      </div>

      <div @mouseleave="showBtn = false" v-show="showBtn" v-if="active == 0" class="overlay-section1">
        <div class="section-hover">
          <div class="box-container">
            <button class="btn btn-primary" @click="enableSection">Enable</button>
          </div>
        </div>
      </div>

      <div class="white_box_tittle ">

        <div class="main-title2 position-relative" style="width:100%">

          <div v-if="is_adviser" class="position-absolute" style="right:0;">
            <a :href="`/subject/${subject.id}/section/${section.id}/assessment/create`" class="btn btn-primary">Add Assessment</a>
          </div>
<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">Disable Section</a>
    <a class="dropdown-item" href="#">Delete</a>
  </div>
</div>

          <h4 class="mb-2 nowrap">{{ section.title }}</h4>
          <p>Preliminary stage</p>
          <p><span style="color: red">*NOTE:</span> you need to upload Module soft-copy for students</p><br>

                <div class="form-group mb-0 typography form-inline">
                    <p><mark>Upload your module here...</mark></p><br><br>
                    <input style="font-size: 10px;" type="file" class="form-control-file" id="exampleFormControlFile1">
                </div>
        </div>
      </div>
      <div class="box_body">
        <div class="default-according" id="accordion">

          <div class="card " v-for="(assessment,i) in assessments" :key="i">
            <div class="card-header parpel_bg" id="headingOne">
              <h5 class="mb-0">

                <button class="btn btn-link collapsed" data-toggle="collapse" :data-target="`#collapseOne${section.id+''+assessment.id}`" aria-expanded="false" aria-controls="collapseOne">{{ assessment.title }}</button>
                <span  style="font-size: 12px; font-weight: normal; ">Due January 14, 2019</span>
                <a style="padding-left: 10px; margin-top: 10px;" class="float-right">...</a>
                <p style="margin-top: 12px;" class="badge badge-warning float-right">Published</p>


              </h5>
            </div>
            <div class="collapse" :id="`collapseOne${section.id+''+assessment.id}`" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">
                <div style="margin-left: 40%; position:absolute; margin-top: -7%; padding: 10px;">
                  <div style="padding: 10px;">
                    <div class="border-left" style="padding: 6px; display: inline-block; padding-right: 30px;">
                      <h3>021</h3><small style="position: absolute; margin-top:-10px;">Turn In</small>
                    </div>
                    <div class="border-left" style="padding: 6px; display: inline-block; padding-right: 30px;">
                      <h3>021</h3><small style="position: absolute; margin-top:-10px;">Assigned</small>
                    </div>
                  </div>
                </div>
                <p style="font-size: 10px;">Posted {{ getDate(assessment.created_at,"ll") }}</p><br>
                <p>{{ assessment.description }}</p><br><br>
                <div v-for="file in assessment.files" :key="file.id">
                  <a :href="file.file"><i class="fa fa-file" aria-hidden="true"> &nbsp; &nbsp;</i>{{ file.name }}</a><br><br>
                </div>

                <div class="border_bottom_1px"></div><br>
                <a href="#">Check Respond</a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

</template>

<script>
import moment from "moment";
export default {
  props: ["section", "is_adviser", "subject", "assessments"],
  data() {
    return {
      showBtn: false,
      active: false,
    };
  },

  mounted() {
    this.active = this.section.status;
    console.log(this.assessments);
  },
  methods: {
    getDate(date, format) {
      return moment(date).format(format);
    },

    async enableSection() {
      try {
        let data = await axios.post("/api/update-section", {
          section_id: this.section.id,
          status: true,
        });
        if (data.data.success) {
          this.active = true;
        }
      } catch (e) {
        console.log(e);
      }
    },
  },
};
</script>

<style scoped>
.overlay-section1 {
  height: 100%;
  width: 100%;
  z-index: 3001;
  position: absolute;
  top: 0;
  left: 0;
  background: rgba(0, 0, 0, 0.8);
}
.section-hover {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  width: 100%;
}
.box-container {
  background: white;
  padding: 10px 20px;
  border-radius: 10px;
}
.overlay-section {
  height: 100%;
  width: 100%;
  z-index: 2000;
  position: absolute;
  top: 0;
  left: 0;
}
.overlay-section.disabled {
  opacity: 0.5;
  background: #ccc;
}
</style>
