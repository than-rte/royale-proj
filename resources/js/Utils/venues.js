export function getSort(sort) {
  switch (sort) {
    case "new":
      return "-created_at";
    case "oldest":
      return "created_at";
    case "name":
      return "name";
    default:
      return "created_at";
  }
}

export function getFilter(status, name=null) {
  let nstatus = status  === "published" ? true : status  === "all" ? undefined : false;
  return name !== null ? {is_publish: nstatus, name} : {is_publish: nstatus};
}

