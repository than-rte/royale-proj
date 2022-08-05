export function isObjEmpty(obj) {
  for (let i in obj) return false;
  return true;
}

export function hasProp(obj, prop) {
  for (let key in obj) {
    if (key === prop) return true;
  }
  return false;
}
