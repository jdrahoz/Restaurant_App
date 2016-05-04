function checkForm(form)
{
  RestaurantField = form.restaurant.value;
  usernameField = form.username.value;
  passField = form.password.value;

  if(usernameField === "" || passField === "" || RestaurantField === "")
  {
    alert("must have a Restaurant Name, us");
    return false;
  }

  if(passField.length < 4)
  {
	alert("Password Must Be 4 Or More Characters");
	return false;
  }
  return true;
}
