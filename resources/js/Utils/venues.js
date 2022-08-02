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

export function getFilter(status, name = null) {
  let nstatus =
    status === "published" ? true : status === "all" ? undefined : false;
  return name !== null
    ? { is_publish: nstatus, name }
    : { is_publish: nstatus };
}

export function getQuerySort(sort) {
  switch (sort) {
    case "-created_at":
      return "new";
    case "created_at":
      return "oldest";
    case "name":
      return "name";
    default:
      return "new";
  }
}

export function hasQueries(queries) {
  for (let query in queries) return true;
  return false;
}

export function hasSort(queries) {
  for (let query in queries) {
    if (query === "sort") return true;
  }
  return false;
}

export function hasFilter(queries) {
  for (let query in queries) {
    if (query === "filter") return true;
  }
  return false;
}

export function hasPublish(queries) {
  for (let query in queries) {
    if (query === "is_publish") return true;
  }
  return false;
}

export function hasSearch(queries) {
  for (let query in queries) {
    if (query === "name") return true;
  }
  return false;
}

export function getQueryStatus(query) {
  if (query === 0) {
    return "unpublished";
  } else if (query === 1) {
    return "published";
  } else {
    return "all";
  }
}
