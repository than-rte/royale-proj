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


export function getMatchRange(from, to, target) {
  if ((from === null && to === null) || to === target || from === target) {
    return {
      from: target,
      to: target
    }
  }

  if (from < target) {
    return {
      from,
      to: target
    }
  } 

  return {
    from: target, 
    to
  }
}