require("./bootstrap");
import Swal from "sweetalert2";

import joinClass from "./components/modals/joinClass.vue";
import CreateAssessment from "./components/CreateAssessment.vue";
import { createApp } from "vue";

const app = createApp({});
app.config.globalProperties.$Swal = Swal;
app.component("join-class", joinClass);
app.component("create-assessment", CreateAssessment);
app.mount("#app");
