export function getFilter(status, venue_search = undefined) {
  return venue_search !== undefined ? { status, venue_search } : { status };
}