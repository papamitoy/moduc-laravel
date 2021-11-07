require("./bootstrap");
import Swal from "sweetalert2";

import joinClass from "./components/modals/joinClass.vue";
import createAssessment from "./components/createAssessment.vue";
import { createApp } from "vue";

const app = createApp({});
app.config.globalProperties.$Swal = Swal;
app.component("join-class", joinClass);
app.component("create-assessment", createAssessment);
app.mount("#app");
