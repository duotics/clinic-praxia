// JavaScript Documentvar http = getXMLHTTPRequest();
//
//	PACIENTE CAPTURE
//
$(document).ready(function() {
	$('.loadFramePacImg').click(function () {
        var urlL = $(this).attr('rel');
		var id = $(this).attr('data-id');
        $('#divLIP').load(urlL,{id:id}); //$('#iframe').reload();
        //console.log('divLIP');
		//$( "#objectID" ).load( "test.php", { "choices[]": [ "Jon", "Susan" ] } );
    });
});


//
//	PACIENTE UPLOAD
//

var loadingHtml = "Loading..."; // this could be an animated image
var imageLoadingHtml = "Image loading...";
  var http = getXMLHTTPRequest();
//----------------------------------------------------------------
  function uploadImage() {
  var uploadedImageFrame = window.uploadedImage;
    uploadedImageFrame.document.body.innerHTML = loadingHtml;
    // VALIDATE FILE
  var imagePath = uploadedImageFrame.imagePath;
  if(imagePath == null){ imageForm.oldImageToDelete.value = "";
  } else { imageForm.oldImageToDelete.value = imagePath; }
  imageForm.submit();
}
//----------------------------------------------------------------
function showImageUploadStatus() {
  var uploadedImageFrame = window.uploadedImage;
  if(uploadedImageFrame.document.body.innerHTML == loadingHtml){ divResult.innerHTML = imageLoadingHtml;
  } else { var imagePath = uploadedImageFrame.imagePath;
    if(imagePath == null){ divResult.innerHTML = "No uploaded image in this form.";
    } else { divResult.innerHTML = "Loaded image: " + imagePath; }
  }
}
//----------------------------------------------------------------
function getXMLHTTPRequest() {
    try { xmlHttpRequest = new XMLHttpRequest();
    } catch(error1) {
      try {xmlHttpRequest = new ActiveXObject("Msxml2.XMLHTTP");
    } catch(error2) {
        try { xmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
        } catch(error3) {
            xmlHttpRequest = false;
        }
    }
  } return xmlHttpRequest;
}
//----------------------------------------------------------------
function sendData() {
    var url = "pacImgUplSubmit.php";
  var parameters = "imageDescription=" + dataForm.imageDescription.value;
  var parameters;
  var imagePath = window.uploadedImage.imagePath;
  if(imagePath != null){ parameters += "&uploadedImagePath=" + imagePath; }
    http.open("POST", url, true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.setRequestHeader("Content-length", parameters.length);
  http.setRequestHeader("Connection", "close");
    http.onreadystatechange = useHttpResponse;
    http.send(parameters);
}
//----------------------------------------------------------------
function submitFormIfNotImageLoading(maxLoadingTime, checkingIntervalTime) {
  if(window.uploadedImage.document.body.innerHTML == loadingHtml) {
    if(maxLoadingTime <= 0) {
      divResult.innerHTML = "The image loading has timed up. " + "Por favor , try again when the image is loaded.";
    } else {
      divResult.innerHTML = imageLoadingHtml;
      maxLoadingTime = maxLoadingTime - checkingIntervalTime;
      var recursiveCall = "submitFormIfNotImageLoading(" + maxLoadingTime + ", " + checkingIntervalTime + ")";
      setTimeout(recursiveCall, checkingIntervalTime);
    }
  } else { sendData(); }
}
  //----------------------------------------------------------------
function submitForm() {
  var maxLoadingTime = 3000; // milliseconds
  var checkingIntervalTime = 500; // milliseconds
  submitFormIfNotImageLoading(maxLoadingTime, checkingIntervalTime);
  location.reload();
}
//----------------------------------------------------------------
function useHttpResponse() {
    if (http.readyState == 4) {
      if (http.status == 200) {
        divResult.innerHTML = http.responseText;
        dataForm.reset();
        imageForm.reset();
        window.uploadedImage.document.body.innerHTML = "";
        window.uploadedImage.imagePath = null;
      }
    }
}

/*
GET MEDIA USER NEW CODE 20210427
*/

const videoPlayer = document.querySelector("#player");
const canvasElement = document.querySelector("#canvas");
const captureButton = document.querySelector("#capture-btn");
const imagePicker = document.querySelector("#image-picker");
const imagePickerArea = document.querySelector("#pick-image");
const newImages = document.querySelector("#newImages");
//var idp=document.querySelector("#idPacPic");//'123';idPacPic

var idp = document.getElementById("idPacPic").value;
console.log(idp);
// Image dimensions
const width = 480;//384;
const height = 360;//216;
let zIndex = 1;

const createImage = (src, alt, title, width, height, className) => {
  let newImg = document.createElement("img");

  if (src !== null) newImg.setAttribute("src", src);
  if (alt !== null) newImg.setAttribute("alt", alt);
  if (title !== null) newImg.setAttribute("title", title);
  if (width !== null) newImg.setAttribute("width", width);
  if (height !== null) newImg.setAttribute("height", height);
  if (className !== null) newImg.setAttribute("class", className);

  return newImg;
};

const startMedia = () => {
  if (!("mediaDevices" in navigator)) {
    navigator.mediaDevices = {};
  }

  if (!("getUserMedia" in navigator.mediaDevices)) {
    navigator.mediaDevices.getUserMedia = constraints => {
      const getUserMedia =
        navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

      if (!getUserMedia) {
        return Promise.reject(new Error("getUserMedia is not supported"));
      } else {
        return new Promise((resolve, reject) =>
          getUserMedia.call(navigator, constraints, resolve, reject)
        );
      }
    };
  }

  navigator.mediaDevices
    .getUserMedia({ video: true })
    .then(stream => {
      videoPlayer.srcObject = stream;
      videoPlayer.style.display = "block";
    })
    .catch(err => {
      imagePickerArea.style.display = "block";
    });
};

// Capture the image, save it and then paste it to the DOM
captureButton.addEventListener("click", event => {
  // Draw the image from the video player on the canvas
  canvasElement.style.display = "block";
  const context = canvasElement.getContext("2d");
  context.drawImage(videoPlayer, 0, 0, canvas.width, canvas.height);

  videoPlayer.srcObject.getVideoTracks().forEach(track => {
    // track.stop();
  });

  // Convert the data so it can be saved as a file
  let picture = canvasElement.toDataURL();

  // Save the file by posting it to the server

  fetch("save_image.php", {
    method: "post",
    body: JSON.stringify({ data: picture, idp: idp })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        // Create the image and give it the CSS style with a random tilt
        //  and a z-index which gets bigger
        //  each time that an image is added to the div
        let newImage = createImage(
          data.path,
          "new image",
          "new image",
          width,
          height,
          "masked"
        );
        console.log(newImage);
        console.log(data.idp);
        let tilt = -(10 * Math.random());
        newImage.style.transform = "rotate(" + tilt + "deg)";
        zIndex++;
        newImage.style.zIndex = zIndex;
        newImages.appendChild(newImage);
        canvasElement.classList.add("masked");
      }
    })
    .catch(error => console.log(error));
});
window.addEventListener("load", event => startMedia());