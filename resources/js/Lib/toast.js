import { ToastProgrammatic as Toast } from "buefy";
import { capitalize } from "lodash";

export function toastAdd(type, name) {
  if(type === 'success') {
    Toast.open({
      type: `is-${type}`,
      message: `${capitalize(name)} has successfully added.`,
      duration: 3000,
      position: "is-bottom",
    });
  }

  if(type === 'danger') {
    Toast.open({
      type: `is-${type}`,
      message: `An error has been occurred.`,
      duration: 3000,
      position: "is-bottom",
    });
  }
}

export function toastUpdate(type, name) {
  if(type === 'success') {
    Toast.open({
      type: `is-${type}`,
      message: `${capitalize(name)} has successfully updated.`,
      duration: 3000,
      position: "is-bottom",
    });
  }

  if(type === 'danger') {
    Toast.open({
      type: `is-${type}`,
      message: `An error has been occurred.`,
      duration: 3000,
      position: "is-bottom",
    });
  }
}

export function toastRemove(type, name) {
  if(type === 'success') {
    Toast.open({
      type: `is-${type}`,
      message: `${capitalize(name)} has successfully remove.`,
      duration: 3000,
      position: "is-bottom",
    });
  }

  if(type === 'danger') {
    Toast.open({
      type: `is-${type}`,
      message: `An error has been occurred.`,
      duration: 3000,
      position: "is-bottom",
    });
  }
}

