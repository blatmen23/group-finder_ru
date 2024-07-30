const period_from_field = document.getElementById("period_from");
const period_before_field = document.getElementById("period_before");

period_from_field.addEventListener("input", period_changed);
period_before_field.addEventListener("input", period_changed);

function period_changed() {
  var period_from_value = period_from_field.value;
  var period_before_value = period_before_field.value;

  period_from_field.max = period_before_value;
  period_before_field.min = period_from_value;
}

// so easy
