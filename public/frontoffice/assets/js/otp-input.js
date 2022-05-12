// function OTPInput() {
//     const inputs = document.querySelectorAll("#otp .col-2 *[id]");
//     for (let i = 0; i < inputs.length; i++) {
//         inputs[i].addEventListener("keydown", function (event) {
//             if (event.key === "Backspace") {
//                 inputs[i].value = "";
//                 if (i !== 0) inputs[i - 1].focus();
//             } else {
//                 if (inputs[i].value !== "") {
//                     inputs[i + 1].focus();
//                 }
//             }
//         });
//     }
// }
// OTPInput();

$('#otp .otp-input').keyup(function(event) {
    const thisId = $(this).attr('id').slice(-1);
    const thisIdNum = parseInt(thisId);
    console.log(thisIdNum);

    if (event.key === "Backspace") {
        $(this).val();
        $(`#otp-${(thisIdNum - 1)}`).focus().val();;
    } else if (event.key !== "Backspace") {
        $(`#otp-${(thisIdNum + 1)}`).focus();
    }
})