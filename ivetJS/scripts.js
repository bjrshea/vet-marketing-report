var $ = jQuery;

function isScrolledIntoView(el) {
  const rect = el.getBoundingClientRect();
  const elemTop = rect.top;
  const elemBottom = rect.bottom;

  // Only completely visible elements return true:
  const isVisible = (elemTop >= 0) && (elemBottom <= window.innerHeight);
  // Partially visible elements return true:
  //isVisible = elemTop < window.innerHeight && elemBottom >= 0;
  return isVisible;
}

$(document).ready(function() {
  try {
    const bodyElement = document.getElementsByTagName("BODY")[0].classList;

    if (bodyElement.contains('page-id-1170')) {

      const hospitalScores = document.getElementsByClassName("hospital-score");
      const learnMoreBtns = document.getElementsByClassName("learn-more");
      const coloredBarsOne = document.getElementsByClassName("colored-bar-one");
      const coloredBarsTwo = document.getElementsByClassName("colored-bar-two");

      $(window).scroll(function() {
        const scrollTop = $(window).scrollTop();
        const navContainer = $('#nav-shell').offset().top;
        const websiteContainerTop = $('#website-container').offset().top;
        const websiteContainerBottom = $('#website-container').offset().top + $('#website-container').height();
        const googleContainerTop = $('#google-container').offset().top;
        const googleContainerBottom = $('#google-container').offset().top + $('#google-container').height();
        const facebookContainerTop = $('#facebook-container').offset().top;
        const facebookContainerBottom = $('#facebook-container').offset().top + $('#facebook-container').height();
        const yelpContainerTop = $('#yelp-container').offset().top;
        const yelpContainerBottom = $('#yelp-container').offset().top + $('#yelp-container').height();
        const nextdoorContainerTop = $('#nextdoor-container').offset().top;
        const nextdoorContainerBottom = $('#nextdoor-container').offset().top + $('#nextdoor-container').height();

        if (scrollTop >= websiteContainerTop && scrollTop < websiteContainerBottom) {
          document.getElementById("website-anchor").classList.add("website-anchor");
        } else {
          document.getElementById("website-anchor").classList.remove("website-anchor");
        }

        if (scrollTop >= googleContainerTop && scrollTop < googleContainerBottom) {
          document.getElementById("google-anchor").classList.add("google-anchor");
        } else {
          document.getElementById("google-anchor").classList.remove("google-anchor");
        }

        if (scrollTop >= facebookContainerTop && scrollTop < facebookContainerBottom) {
          document.getElementById("facebook-anchor").classList.add("facebook-anchor");
        } else {
          document.getElementById("facebook-anchor").classList.remove("facebook-anchor");
        }

        if (scrollTop >= yelpContainerTop && scrollTop < yelpContainerBottom) {
          document.getElementById("yelp-anchor").classList.add("yelp-anchor");
        } else {
          document.getElementById("yelp-anchor").classList.remove("yelp-anchor");
        }

        if (scrollTop >= nextdoorContainerTop && scrollTop < nextdoorContainerBottom) {
          document.getElementById("nextdoor-anchor").classList.add("nextdoor-anchor");
        } else {
          document.getElementById("nextdoor-anchor").classList.remove("nextdoor-anchor");
        }

        if (scrollTop >= navContainer) {
          console.log('fixed on');
          document.getElementById("nav-container").classList.add("fixed-header");
        } else {
          console.log('fixed removed');
          document.getElementById("nav-container").classList.remove("fixed-header");
        }

        for (let i = 0; i < coloredBarsOne.length; i++) {
          if (isScrolledIntoView(coloredBarsOne[i]) === true) {
            coloredBarsOne[i].classList.add("translate-zero");
            setTimeout(function timer() {
              coloredBarsTwo[i].classList.add("translate-zero");
            }, 500);
          }
        }
      });

      for (let i = 0; i < hospitalScores.length; i++) {
        if (hospitalScores[i].innerHTML === "Yes") {
          hospitalScores[i].style.color = "#40BEB6";
          hospitalScores[i].nextSibling.nextSibling.style.display = "block";
          coloredBarsOne[i].style.backgroundColor = "#40BEB6";
        } else if (hospitalScores[i].innerHTML === "No") {
          hospitalScores[i].style.color = "#BF261A";
          hospitalScores[i].nextSibling.nextSibling.nextSibling.nextSibling.style.display = "block";
          coloredBarsOne[i].style.backgroundColor = "#BF261A";
         } else {
          const hospitalScore = parseFloat(hospitalScores[i].innerHTML);
          const industryScore = parseFloat(hospitalScores[i].parentElement.parentElement.parentElement.parentElement.children[1].children[0].children[0].children[0].innerHTML);
          if (hospitalScores[i].parentElement.parentElement.parentElement.children[2].innerHTML === "Your website load time") {
            if (hospitalScore <= industryScore) {
              hospitalScores[i].style.color = "#40BEB6";
              hospitalScores[i].nextSibling.nextSibling.style.display = "block";
              coloredBarsOne[i].style.backgroundColor = "#40BEB6";
            } else {
              hospitalScores[i].style.color = "#BF261A";
              hospitalScores[i].nextSibling.nextSibling.nextSibling.nextSibling.style.display = "block";
              coloredBarsOne[i].style.backgroundColor = "#BF261A";
            }
          } else {
            if (hospitalScore >= industryScore) {
              hospitalScores[i].style.color = "#40BEB6";
              hospitalScores[i].nextSibling.nextSibling.style.display = "block";
              coloredBarsOne[i].style.backgroundColor = "#40BEB6";
            } else {
              hospitalScores[i].style.color = "#BF261A";
              hospitalScores[i].nextSibling.nextSibling.nextSibling.nextSibling.style.display = "block";
              coloredBarsOne[i].style.backgroundColor = "#BF261A";
            }
          }
        }
      }

      for (let i = 0; i < learnMoreBtns.length; i++) {
        learnMoreBtns[i].addEventListener("click", function() {
          console.log(this.parentElement.children[0].innerHTML);
          if (this.parentElement.children[0].innerHTML === "WEBSITE EXPERIENCE") {
            if (this.parentElement.parentElement.children[6].style.maxHeight === "0px") {
              this.classList.add("learn-more-active");
              this.parentElement.parentElement.children[6].style.maxHeight = this.parentElement.parentElement.children[6].scrollHeight + "px";
              this.parentElement.parentElement.children[6].style.opacity = "1";
              this.parentElement.children[1].children[1].classList.add("plus-minus-active");
            } else {
              this.classList.remove("learn-more-active");
              this.parentElement.parentElement.children[6].style.maxHeight = "0px";
              this.parentElement.parentElement.children[6].style.opacity = "0";
              this.parentElement.children[1].children[1].classList.remove("plus-minus-active");
            }
          } else if (this.parentElement.children[0].innerHTML === "GOOGLE REVIEWS" || this.parentElement.children[0].innerHTML === "GMB QUESTIONS &amp; ANSWERS" || this.parentElement.children[0].innerHTML === "FACEBOOK RECOMMENDATIONS" || this.parentElement.children[0].innerHTML === "FACEBOOK LIKES &amp; FOLLOWERS" || this.parentElement.children[0].innerHTML === "YELP REVIEWS" || this.parentElement.children[0].innerHTML === "YELP ASK THE COMMUNITY") {
            if (this.parentElement.parentElement.children[4].style.maxHeight === "0px") {
              this.classList.add("learn-more-active");
              this.parentElement.parentElement.children[4].style.maxHeight = this.parentElement.parentElement.children[4].scrollHeight + "px";
              this.parentElement.parentElement.children[4].style.opacity = "1";
              this.parentElement.children[1].children[1].classList.add("plus-minus-active");
            } else {
              this.classList.remove("learn-more-active");
              this.parentElement.parentElement.children[4].style.maxHeight = "0px";
              this.parentElement.parentElement.children[4].style.opacity = "0";
              this.parentElement.children[1].children[1].classList.remove("plus-minus-active");
            }
          } else {
            if (this.parentElement.parentElement.children[3].style.maxHeight === "0px") {
              this.classList.add("learn-more-active");
              this.parentElement.parentElement.children[3].style.maxHeight = this.parentElement.parentElement.children[3].scrollHeight + "px";
              this.parentElement.parentElement.children[3].style.opacity = "1";
              this.parentElement.children[1].children[1].classList.add("plus-minus-active");
            } else {
              this.classList.remove("learn-more-active");
              this.parentElement.parentElement.children[3].style.maxHeight = "0px";
              this.parentElement.parentElement.children[3].style.opacity = "0";
              this.parentElement.children[1].children[1].classList.remove("plus-minus-active");
            }
          }
        });
      }
    }

    if (bodyElement.contains('page-id-1121')) {
      checkAdsPercentages();
    }

    if (bodyElement.contains('page-id-1133') || bodyElement.contains('page-id-1087')) {
      numberScores();
      yesNoScores();
      checkElementHeight();
      $(".more-info").click(function(){
        const classList = this.classList;
        let panel = $(this)[0].parentElement.parentElement.children[2];
        if (classList.contains("green") === true) {
          $(this).removeClass("green");
          panel.style.maxHeight = null;
        } else {
          $(this).addClass("green");
          panel.style.maxHeight = panel.scrollHeight + "px";
        }
      });
      $(window).scroll(function() {
        checkElementHeight();
      });
    }

    if (bodyElement.contains('page-id-1145')) {

      passOrFail();
      numberCheck("cat-performance", 75);
      numberCheck("cat-seo", 75);
      numberCheck("cat-organic", 50);
      textCheck("cat-cadence", "Daily", "Weekly");
      textCheck("cat-engagement", "High", "Medium");
      countResults("hos-result", "hos-pass", "hos-fail", "hospital-chart", 0);
      countResults("one-result", "one-pass", "one-fail", "comp-one-chart", 200);
      countResults("two-result", "two-pass", "two-fail", "comp-two-chart", 300);

      sectionScore("hospital-bar", 0, "hos-performance", 5);
      sectionScore("one-bar", 0, "one-performance", 5);
      sectionScore("two-bar", 0, "two-performance", 5);

      sectionScore("hospital-bar", 1, "hos-local", 13);
      sectionScore("one-bar", 1, "one-local", 13);
      sectionScore("two-bar", 1, "two-local", 13);

      sectionScore("hospital-bar", 2, "hos-social", 2);
      sectionScore("one-bar", 2, "one-social", 2);
      sectionScore("two-bar", 2, "two-social", 2);

      sectionScore("hospital-bar", 3, "hos-ecs", 4);
      sectionScore("one-bar", 3, "one-ecs", 4);
      sectionScore("two-bar", 3, "two-ecs", 4);

      sectionScore("hospital-bar", 4, "hos-google", 3);
      sectionScore("one-bar", 4, "one-google", 3);
      sectionScore("two-bar", 4, "two-google", 3);

      sectionScore("hospital-bar", 5, "hos-special", 4);
      sectionScore("one-bar", 5, "one-special", 4);
      sectionScore("two-bar", 5, "two-special", 4);

      barGraphHover();
    }
  } catch(e) {
    console.log(e);
  }
});

function checkElementHeight() {
  const fadeElements = document.getElementsByClassName("fade-element");
  const windowTop = $(window).scrollTop();
  for (var i = 0; i < fadeElements.length; i++) {
    if (fadeElements[i].classList.contains("fade-in") === false) {
      if ((fadeElements[i].offsetTop - 600) < windowTop) {
        fadeElements[i].classList.add("fade-in");
      }
    }
  }
}

function numberScores() {
  let inputtedNumbers = document.getElementsByClassName("inputted-number");
  let industryAvg = document.getElementsByClassName("industry-avg");
  inputtedNumbers = Array.from(inputtedNumbers);
  industryAvg = Array.from(industryAvg);
  const matrix = [];
  for (var i = 0; i < inputtedNumbers.length; i++) {
    matrix.push([inputtedNumbers[i], industryAvg[i]])
  }
  for (var i = 0; i < matrix.length; i++) {
    if (matrix[i][0].innerHTML.includes("Seconds") === true) {
      if (parseFloat(matrix[i][0].innerHTML) > parseFloat(matrix[i][1].innerHTML)) {
        matrix[i][0].className += " red";
      } else {
        matrix[i][0].className += " green";
      }
    } else {
      if (parseFloat(matrix[i][0].innerHTML) < parseFloat(matrix[i][1].innerHTML)) {
        matrix[i][0].className += " red";
      } else {
        matrix[i][0].className += " green";
      }
    }
  }
}

function yesNoScores() {
  const arrayOfScores = document.getElementsByClassName("yes-no");
  for (let i = 0; i < arrayOfScores.length; i++) {
    if (arrayOfScores[i].innerHTML === "Yes") {
      arrayOfScores[i].className += " green";
    } else if (arrayOfScores[i].innerHTML === "No") {
      arrayOfScores[i].className += " red";
    }
  }
}

function checkAdsPercentages() {
  const arrayOfPercentages = document.getElementsByClassName("ads-percentage");
  for (var i = 0; i < arrayOfPercentages.length; i++) {
    let percentage = parseInt(arrayOfPercentages[i].children[0].textContent);
    if (arrayOfPercentages[i].className === "ads-percentage reverse") {
      if (percentage > 0) {
        arrayOfPercentages[i].style.color = "#c42127";
      } else if (percentage < 0) {
        arrayOfPercentages[i].style.color = "#009966";
      } else {
        arrayOfPercentages[i].style.color = "black";
      }
    } else {
      if (percentage > 0) {
        arrayOfPercentages[i].style.color = "#009966";
      } else if (percentage < 0) {
        arrayOfPercentages[i].style.color = "#c42127";
      } else {
        arrayOfPercentages[i].style.color = "black";
      }
    }
  }
}

function passOrFail() {
  const passOrFail = document.getElementsByClassName("pass-fail");

  for (let i = 0; i < passOrFail.length; i++) {
    if (passOrFail[i].innerHTML === "Pass") {
      passOrFail[i].innerHTML = "<i class='fas fa-check'></i>";
      passOrFail[i].classList.add("pass");
    } else {
      passOrFail[i].innerHTML = "<i class='fas fa-times'></i>";
      passOrFail[i].classList.add("fail");
    }
  }
}

function numberCheck(metricClass, benchmark) {
  const metric = document.getElementsByClassName(metricClass);

  for (let i = 0; i < metric.length; i++) {
    if (parseInt(metric[i].innerHTML) > benchmark) {
      metric[i].classList.add("green-cat-background");
      metric[i].classList.add("pass");
    } else {
      metric[i].classList.add("red-cat-background");
      metric[i].classList.add("fail");
    }
  }
}

function textCheck(metricClass, passOne, passTwo) {
  const metric = document.getElementsByClassName(metricClass);

  for (let i = 0; i < metric.length; i++) {
    if (metric[i].innerHTML === passOne || metric[i].innerHTML === passTwo) {
      metric[i].classList.add("green-cat-color");
      metric[i].classList.add("pass");
    } else {
      metric[i].classList.add("red-cat-color");
      metric[i].classList.add("fail");
    }
  }
}

function countResults(resultsClass, passID, failID, chartID, delayTime) {
  const results = document.getElementsByClassName(resultsClass);
  let passes = 0;
  let fails = 0;

  for (let i = 0; i < results.length; i++) {
    if (results[i].classList.contains("pass")) {
      passes += 1;
    }
    if (results[i].classList.contains("fail")) {
      fails += 1;
    }
  }

  let percentage = fails / 31;
  percentage = percentage * 100;
  percentage = Math.round(percentage);

  document.getElementById(passID).innerHTML = 100 - percentage;
  document.getElementById(failID).innerHTML = percentage;

  $(document).scroll(function() {
    if (isScrolledIntoView(document.getElementById("results-box")) === true) {
      setTimeout(function timer() {
        if (percentage <= 50) {
          percentage = percentage.toString();
          setTimeout(function timer() {
            countResults("one-result", "one-pass", "one-fail", "comp-one-chart");
          }, 200);
          document.getElementById(chartID).style.backgroundColor = "#009966";
          document.getElementById(chartID).style.transform = `rotate(.${percentage}turn)`;
        }
      }, delayTime);
    }
  });

}

function sectionScore(hospitalBar, hospitalBarNumber, sectionClass, sectionQuestionCount) {
  const bar = document.getElementsByClassName(hospitalBar)[hospitalBarNumber];
  let percentage;
  let passes = 0;

  const results = document.getElementsByClassName(sectionClass);

  for (let i = 0; i < results.length; i++) {
    if (results[i].classList.contains("pass")) {
      passes += 1;
    }
  }

  percentage = passes / sectionQuestionCount;
  percentage = percentage * 100;
  percentage = Math.round(percentage);
  percentage = percentage.toString();

  bar.style.height = `${percentage}%`;
}

function barGraphHover() {
  const hospital = document.getElementById('hospital-hover');
  const compOne = document.getElementById('comp-one-hover');
  const compTwo = document.getElementById('comp-two-hover');

  const hospitalBars = document.getElementsByClassName('hospital-bar');

  const oneBar = document.getElementsByClassName('one-bar');

  const twoBar = document.getElementsByClassName('two-bar');

  console.log(oneBar);

  console.log(twoBar);

  hospital.addEventListener('mouseover', function(){
    console.log('do i run');
    for (let i = 0; i < oneBar.length; i++) {
      oneBar[i].classList.add('gray-bar');
    }
    for (let i = 0; i < twoBar.length; i++) {
      twoBar[i].classList.add('gray-bar');
    }
  });

  compOne.addEventListener('mouseover', function(){

  });

  compTwo.addEventListener('mouseover', function(){

  });

  hospital.addEventListener('mouseout', function(){
    for (let i = 0; i < oneBar.length; i++) {
      oneBar[i].classList.remove('gray-bar');
    }
    for (let i = 0; i < twoBar.length; i++) {
      twoBar[i].classList.remove('gray-bar');
    }
  });

  compOne.addEventListener('mouseout', function(){

  });

  compTwo.addEventListener('mouseout', function(){

  });
}
