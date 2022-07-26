import moment from "moment";

export const momentPlugin = {
  install(Vue) {
    Object.defineProperty(Vue.prototype, "$moment", {
      get() {
        return moment;
      },
    });
  },
};
