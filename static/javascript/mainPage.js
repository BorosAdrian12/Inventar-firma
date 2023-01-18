var page = 0;
var pageSize = 10;
var index = 0;
var blockleft = false;
var productDisplaiContent;
var displayPlace = document.getElementById("display");
let listType;
let listUsers;
let listDeposit;
var itemSearchlocal;
let templateRowLog = (id, name, action, extra = "-", time) => {
  return `<tr>
    <td>${id}</td>
    <td>${name}</td>
    <td>${action}</td>
    <td>${extra}</td>
    <td>${time}</td>
  </tr>`;
};
let templateItemType = (nume, nr, id = 0, locType = "") => {
  return `
<div class="productRow"  >
<div class="productRowData" id="produs_${id}"><span class="product-name" id= "produs_${id}_data" >${nume}</span>
<span class="product-count">count</span>
<span class="product-count minwid50" id="produs_${id}_count" >${nr}</span></div>
<button class="delete-button" onclick="deleteObject(${id},'${locType}')">Delete</button>
</div>`;
};
let templateUser = (name, id = 0) => {
  return `
    <div class="itemplace" id="produs_${id}" style="width:200px">
    <center>
      <div onclick="getAllItemFromUser(${id},'${name}')">
       <br><br>
        <div class="itemplace-content">
          <div class="name">nume</div>
          <div class="itemplace-content-data">${name}</div>
        </div>
        
        </div>
        <br><br> <br>
      </div>
      
     
      </div>
    </center>
    
  </div>`;
};
let templateUserProducts=(id,name,series)=>{
    return `<div class="itemplace" id="produs_${id}">
    <center>
      <div onclick="ItemInfoDisplay(${id})">
        <div class="itemplace-content">
          <div class="name">nume</div>
          <div class="itemplace-content-data">${name}</div>
        </div>
        <div class="itemplace-content">
          <div class="name">serie:</div>
          <div class="itemplace-content-data">${series}</div>
        </div>
        
      </div>
      <div class="itemplace-content spaceout">
        <button class="btn-item greenbtn" onclick="">edit</button>
        <button class="btn-item redbtn" onclick="">delete</button>
      </div>
    </center>
  </div>`;
}
let templateProduct = (name, series, id, where, wheredata = 1) => {
  /**
     * 
     * <div class="magazin" id="produs_${id}">
    <br>
    <div>${name}</div>
    <div>serie:${series}</div>
    <br>
    </div>
     */
  return `
    
    <div class="itemplace" id="produs_${id}">
      <center>
        <div onclick="ItemInfoDisplay(${id})">
          <div class="itemplace-content">
            <div class="name">nume</div>
            <div class="itemplace-content-data">${name}</div>
          </div>
          <div class="itemplace-content">
            <div class="name">serie:</div>
            <div class="itemplace-content-data">${series}</div>
          </div>
          <div class="itemplace-content">
            <div class="name">${where}</div>
            <div class="itemplace-content-data">${wheredata}</div>
          </div>
        </div>
        <div class="itemplace-content spaceout">
          <button class="btn-item greenbtn" onclick="">edit</button>
          <button class="btn-item redbtn" onclick="">delete</button>
        </div>
      </center>
    </div>
    `;
};
let templateMagazie = (name, location, count, id, locType = "") => {
  if (locType != "") locType = `onclick="deleteObject(${id},'${locType}')"`;
  return `
    
    <div class="itemplace" id="magazie_${id}">
      <center>
        <div onclick="selectAllItemFromDepositTest(${id},'${name}')">
          <div class="itemplace-content">
            
            <div class="itemplace-content-data" id="magazie_${id}_data">${name}</div>
          </div>
          <div class="itemplace-content">
            
            <div class="itemplace-content-data">${location}</div>
          </div>
          <div class="itemplace-content">
            <div class="name">nr. produse:</div>
            <div class="itemplace-content-data">${count}</div>
          </div>
        </div>
        <div class="itemplace-content spaceout">
          <button class="btn-item greenbtn" onclick="">edit</button>
          <button class="btn-item redbtn" ${locType} >delete</button>
        </div>
      </center>
    </div>
    `;
};
let templateItemInfo = (name,series,type,location) =>{
    return `<div class="product-info-item">
    <h2 class="product-name-item">${name}</h2>
    <p class="product-series-item">${series}</p>
    <p class="product-type-item">${type}</p>
    <p class="product-location-item">${location}</p>
  </div>
`;
}
let templateTitlu = (titlu) => {
  return `
    <div>
    <br>
        <h2>${titlu}</h2>
        <br>
        <div>
   <input type="text" id="search-input" placeholder="cauta produsul">
   <div id="search-result-local" class="item-search"></div>
</div>
    </div>
    `;
};
function initProduse() {
  console.log("initProduse");

  page = 0;
  let place = document.getElementById("product_display_place");

  let text = "";
  // text+=template("laptop",123);
  // text+=template("tastatura",12);
  getItemTypePage(page).then((res) => {
    for (let i = 0; i < res.id.length; i++) {
      text += templateItemType(
        res.name[i],
        res.count[i],
        res.id[i],
        "itemtype"
      );
    }
    productDisplaiContent = res;
    place.innerHTML = text;
    let produsButton = document.getElementsByClassName("productRowData");
    Array.from(produsButton).forEach(function (element) {
      element.addEventListener("click", selectAllItemwithType);
    });
  });
  //o sa trebuiasca un fetch din baza de date
  index = 0;
  document.getElementById("index").innerHTML = index;
}
function initMagazie() {
    setSearch("search-input", "search-result-local", 'selectAllItemFromDepositTest','null',"searchDeposits",magaziereSearchRefresh);
  console.log("initMagazii");
  let place = document.getElementById("content-magazin");
  fetch(`https://${window.location.hostname}/api/getAllDeposit`)
    .then((res) => {
      if (!res.ok) {
        console.log("o puscat fetchul");
      } else {
        // console.log("a mers");
        return res.json();
      }
    })
    .then((res) => {
      console.log(res);
      let text='';
      for (let i = 0; i < res.id.length; i++) {
        text += templateMagazie(
          res.name[i],
          res.address_location[i],
          res.count[i],
          res.id[i],
          "deposit"
        );
        // console.log(i);
      }
      text += "</div>";
      place.innerHTML = text;
      let depositButton = document.getElementsByClassName("itemplace");
      // Array.from(depositButton).forEach(function(element) {
      //     element.addEventListener('click', selectAllItemFromDeposit);
      //   });
    });
}
async function initAddItem() {
  console.log("din initAddItem");
  let typeSelect = document.getElementById("item-form-type");
  let locationTypeSelect = document.getElementById("item-form-locationType");
  initListData().then((res) => {
    loadOption(typeSelect, res);
  });
  // fetch(`https://${window.location.hostname}/api/getAlltype`).then(res=>{return res.json();}).then((res)=>{loadOption(typeSelect,res);listType=res;})
  // fetch(`https://${window.location.hostname}/api/getAllUsers`).then(res=>{return res.json();}).then((res)=>{listUsers=res;})
  // fetch(`https://${window.location.hostname}/api/getAlldepositName`).then(res=>{return res.json();}).then((res)=>{listDeposit=res;})
  let form = document.querySelector("form");
  form.addEventListener("submit", (e) => {
    console.log("am apasat pe buton")
    e.preventDefault();
    // let formData = new FormData(form);
    // console.log(formData);
    // console.log("ai dat submit la form");
    // console.log(listType, listDeposit, listUsers);
    // formData.set("type", listType.id[parseInt(formData.get("type")) - 1]);
    // if (formData.get("locationType") == "deposit") {
    //   formData.set(
    //     "selectedPlace",
    //     listDeposit.id[parseInt(formData.get("selectedPlace")) - 1]
    //   );
    // } else {
    //   formData.set(
    //     "selectedPlace",
    //     listUsers.id[parseInt(formData.get("selectedPlace")) - 1]
    //   );
    // }

    // for(item of formData){
    //     console.log(item[0],item[1])
    // }
    let data={
        name:document.getElementById("item-form-name").value,
        series:document.getElementById("item-form-series").value,
        type:document.getElementById("item-form-type").value,
        locationType:document.getElementById("item-form-locationType").value,
        selectedPlace:document.getElementById("item-form-selectData").value
    }
    // console.log(data);
    fetch(`https://${window.location.hostname}/api/addItem`, {
      method: "POST",
      body: JSON.stringify(data ),
    })
      .then((res) => res.json())
      .then((res) => {
        let mesaj;
        if(res.status=="bad"){
            mesaj="nu se poate introduce deoarece exista probleme"
        }else{
            mesaj="s-a introdus cu succes";
        }
        
        let notification=document.getElementById("notification");
        notification.innerHTML=mesaj;
        notification.style.display="block";
        setTimeout(() => {
            notification.style.display="none";
        }, 3000);
      });
  });
}
function initLog() {
  let place = document.getElementById("log-table-content");
  fetch(`https://${window.location.hostname}/api/getLogs`)
    .then((res) => {
      return res.json();
    })
    .then((res) => {
      console.log(res);
      let text = "";
      for (let i = 0; i < res.id.length; i++) {
        text += templateRowLog(
          res.id[i],
          res.whoDidIt[i],
          res.action[i],
          res.data[i],
          res.timeAction[i]
        );
      }
      place.innerHTML = text;
    });
}
function initTransport() {
  initListData();
  setSearch("search-input", "search-result-local", "addDataTransport",'',"searchItem");
  let form = document.getElementById("item-formid");
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    // let formData = new FormData(form);
    // console.log(formData.get("locationType"));

    // if (formData.get("locationType") == "deposit") {
    //   formData.set(
    //     "selectedPlace",
    //     listDeposit.id[parseInt(formData.get("selectedPlace")) - 1]
    //   );
    // } else {
    //   formData.set(
    //     "selectedPlace",
    //     listUsers.id[parseInt(formData.get("selectedPlace")) - 1]
    //   );
    // }
    let data = {
      locationType: formData.get("locationType"),
      idItem: document.getElementById("itemId").value,
      idPlace: formData.get("selectedPlace"),
    };
    console.log(data);
    // for(item of formData){
    //     console.log(item[0],item[1])
    // }
    fetch(`https://${window.location.hostname}/api/modifyItemLocation`, {
      method: "POST",
      body: JSON.stringify(data),
    })
      .then((res) => res.json())
      .then((res) => console.log(res));
  });
}

function initUsers() {
  // console.log("din initUsers");
  let place = document.getElementById("content-users");
  
  fetch(`https://${window.location.hostname}/api/getAllUsers`)
    .then((res) => {
      if (!res.ok) {
        console.log("o puscat fetchul");
      } else {
        // console.log("a mers");
        return res.json();
      }
    })
    .then((res) => {
    //   console.log(res);
    let text = "<div>";
      for (let i = 0; i < res.id.length; i++) {
        text += templateUser(res.name[i], res.id[i], "deposit");
        // console.log(i);
      }
      text += "</div>";
      place.innerHTML = text;
      setSearch("search-input", "search-result-local", "addDataTransport",'',"searchItem");
    //   let depositButton = document.getElementsByClassName("itemplace");
    //   Array.from(depositButton).forEach(function (element) {
    //     element.addEventListener("click", getAllItemFromUser);
    //   });
    });
}

function addDataTransport(e) {
    let id=e.value;
  fetch(`https://${window.location.hostname}/api/getItem?id=${id}`)
    .then((res) => res.json())
    .then((res) => {
      console.log(res.id[0]);
      document.getElementById("itemId").value = res.id[0];
      document.getElementById("nameItem").value = res.name[0];
      document.getElementById("location").innerHTML = res.data[0];
      document.getElementById("search-result-local").style.display = "none";
    });
}

function setSearch(inputbox, suggestionBox, whathappen = "", data = "null",apiFunction,atEnter) {
  const searchInput = document.getElementById(inputbox);
  searchInput.addEventListener("keydown", function (e) {
    if (e.code === "Enter") {
      atEnter(e);
    }
  });
  searchInput.addEventListener("input", (e) => {
    const value = e.target.value;
    let suggestion = document.getElementById(suggestionBox);
    if (value.length < 3) {
      suggestion.innerHTML = "";
      suggestion.style.display = "none";
      return;
    }
    fetch(`https://${window.location.hostname}/api/${apiFunction}?search=${value}`)
      .then((res) => res.json())
      .then((res) => {
        suggestion.style.display = "block";
        //  let rand='';
        let rand = [];
        let text = "";
        try {
          for (let i = 0; i < res.id.length; i++) {
            text += `<li  value="${res.id[i]}"onclick="${whathappen}(this,${data})">${res.name[i]},${res.data[i]}</li>`;
            rand.push(`${res.name[i]},${res.data[i]}`);
          }
        } catch (error) {
          // console.log({searchstatus:"nothing was find"})
        }
        // console.log(rand);
        suggestion.innerHTML = text;
      });
  });
}
function magaziereSearchRefresh(e){
    let search=e.value;
    fetch(`https://${window.location.hostname}/api/searchDeposits?search=${search}`)
    .then((res)=>{return res.json()})
    .then((res)=>{
        console.log(search)
        let iteme = document.getElementById("content-magazin");
        if(res.id==null){
            return;
        }
        let text = "<div>";
      
      for (let i = 0; i < res.id.length; i++) {
        text += templateMagazie(
          res.name[i],
          res.address_location[i],
          res.count[i],
          res.id[i],
          "deposit"
        );
        // console.log(i);
      }
      text += "</div>";
      place.innerHTML = text;
    })
}
function loadOption(where, res) {
  let text = "<option></option>";
  for (let i = 0; i < res.name.length; i++)
    text += "<option value=" + res.id[i] + ">" + res.name[i] + "</option>";
  where.innerHTML = text;
}
function getComboA(selectObject) {
  //apartine de item loc
  var value = selectObject.value;
  console.log(value);
  let selectSelect = document.getElementById("item-form-selectData");
  switch (value) {
    case "deposit":
      loadOption(selectSelect, listDeposit);
      break;
    case "user":
      loadOption(selectSelect, listUsers);
      break;
    default:
      selectSelect.innerHTML = "";
      break;
  }
}
function getItemTypePage(page) {
  return fetch(
    `https://${window.location.hostname}/api/getItemTypeList?page=${page}`
  ).then((res) => {
    if (!res.ok) {
      console.log("o puscat fetchul");
    } else {
      // console.log("a mers");
      return res.json();
    }
  });
}
function filloption() {}
function changePageProduct(direction) {
  if (index + direction < 0) return;
  let place = document.getElementById("product_display_place");

  // console.log(index);
  let text = "";
  getItemTypePage(index + direction).then((res) => {
    // console.log(res);
    if (res.id.length == 0) {
      index -= direction;
      return;
    } else {
      index += direction;
    }

    for (let i = 0; i < res.id.length; i++) {
      text += templateItemType(
        res.name[i],
        res.count[i],
        res.id[i],
        "itemtype"
      );
    }
    productDisplaiContent = res;
    // console.log(productDisplaiContent)
    place.innerHTML = text;
    document.getElementById("index").innerHTML = index;
  });
}

var initArr = {
  Produse: initProduse,
  Magazie: initMagazie,
  AddItem: initAddItem,
  Log: initLog,
  Transport: initTransport,
  Users: initUsers,
};

function displayContent(contentRequest) {
  // let displayPlace = document.getElementById("display");
  // fetch("https://www.google.com/"/*`./dissasdplay.php?displayFrame=${contentRequest}`*/)
  // .then((res)=>{
  //     if(res.ok)
  //         displayPlace.innerHTML="ceva nu a mers";
  //     displayPlace.innerHTML="da";
  // })
  // var displayPlace=document.getElementById("display");
  fetch(
    `https://${window.location.hostname}/default/component/getView?view=${contentRequest}`
  )
    .then((res) => {
      if (!res.ok) {
        console.log("o puscat fetchul");
      } else {
        // console.log("a mers");
        return res.text();
      }
    })
    .then((res) => {
      displayPlace.innerHTML = res;
      // console.log(res);
      console.log("din displayContent = " + contentRequest);
      if (contentRequest in initArr) initArr[contentRequest]();
    });
}
// displayContent("Magazie");
let butoaneSchimbaDisplay = document.getElementsByClassName("button");
var displayChangeDisplay = function () {
  var attribute = this.value;
  displayContent(attribute);
  console.log(this.value); //debug
};
function printItems(res, where, multipleData = "") {
  console.log(res);
  if(res==null){
    return;
  }
  if(res.id.length==0){
    return
  }
  let text = multipleData+'<div class="displayflex">';
  for (let i = 0; i < res.id.length; i++) {
    text += templateProduct(
      res.name[i],
      res.series[i],
      res.id[i],
      where,
      res.data[i]
    );
  }
  displayPlace.innerHTML = text + "</div>";
}
var selectAllItemwithType = async function () {
  let id = this.id.substring(7); //produs_${id}

  let id_titlu = this.id + "_data";
  let value = document.getElementById(id_titlu).innerHTML;

  fetch(
    `https://${window.location.hostname}/api/getItemWithTypeWithId?id=${id}`
  )
    .then((res) => {
      if (!res.ok) {
        console.log("o puscat fetchul");
      } else {
        // console.log("a mers");
        return res.json();
      }
    })
    .then((res) => {
        
      
      printItems(res, "locatie", templateTitlu(value));
      setSearch("search-input", "search-result-local", "addDataTransport",'',"searchItem");
    });
};

function getAllItemFromUser(id, titlu) {
  //let id=id;//magazie_${id}

  let value = titlu;
  fetch(`https://${window.location.hostname}/api/getAllItemFromUser?id=${id}`)
    .then((res) => {
      if (!res.ok) {
        console.log("o puscat fetchul");
      } else {
        // console.log("a mers");
        return res.json();
      }
    })
    .then((res) => {
      if(res==null){
        return;
      }
      let text = templateTitlu(titlu)+'<div class="displayflex">';
      setSearch("search-input", "search-result-local", "addDataTransport",'',"searchItem");
    //   console.log(res);
      for (let i = 0; i < res.id.length; i++) {
        text += templateUserProducts(res.id[i],res.name[i], res.series[i]);
        // console.log(i);
      }
      displayPlace.innerHTML = text + "</div>"
    });
}
function selectAllItemFromDepositTest(id, titlu) {
  //let id=id;//magazie_${id}
        if(id.value!=undefined){
            id=id.value;
        }
    
  let value;
  fetch(
    `https://${window.location.hostname}/api/getAllItemFromDeposit?id=${id}`
  )
    .then((res) => {
      if (!res.ok) {
        console.log("o puscat fetchul");
      } else {
        // console.log("a mers");
        return res.json();
      }
    })
    .then((res) => {
      
      printItems(res, "tip", templateTitlu(titlu));
      setSearch("search-input", "search-result-local", "addDataTransport",'',"searchItem");
    });
}
var selectAllItemFromDeposit = function () {
  let id = this.id.substring(8); //magazie_${id}
  let id_titlu = this.id + "_data";
  let value = document.getElementById(id_titlu).innerHTML;
  fetch(
    `https://${window.location.hostname}/api/getAllItemFromDeposit?id=${id}`
  )
    .then((res) => {
      if (!res.ok) {
        console.log("o puscat fetchul");
      } else {
        // console.log("a mers");
        return res.json();
      }
    })
    .then((res) => {
      printItems(res, "tip", templateTitlu(value));
      setSearch("search-input", "search-result-local", "addDataTransport",'',"searchItem");
    });
};

Array.from(butoaneSchimbaDisplay).forEach(function (element) {
  element.addEventListener("click", displayChangeDisplay);
});

function submitForm(form, url) {
  var xhr = new XMLHttpRequest();
  xhr.open(form.method, url);
  xhr.onload = function () {
    if (xhr.status === 200) {
      // Update the page with the response from the server
    }
  };
  xhr.send(new FormData(form));
  displayContent("Produse");
}
function deleteObject(id, objName) {
  fetch(`https://${window.location.hostname}/api/deleteObject`, {
    method: "POST",
    body: JSON.stringify({
      nameObject: objName,
      id: id,
    }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((res) => res.json())
    .then((res) => console.log(res));
}
console.log("asta este din fisier");
function initListData() {
  let x = fetch(`https://${window.location.hostname}/api/getAlltype`)
    .then((res) => {
      return res.json();
    })
    .then((res) => {
      listType = res;
      return res;
    });
  fetch(`https://${window.location.hostname}/api/getAllUsers`)
    .then((res) => {
      return res.json();
    })
    .then((res) => {
      listUsers = res;
    });
  fetch(`https://${window.location.hostname}/api/getAlldepositName`)
    .then((res) => {
      return res.json();
    })
    .then((res) => {
      listDeposit = res;
    });
  return x;
}
function ItemInfoDisplay(id){
    fetch(
        `https://${window.location.hostname}/api/getItemInfo?id=${id}`
      )
      .then((res)=>{
        return res.json();
      }).then((res)=>{
        if(res==null){
            return;
        }
        // console.log(res.data[0]);
        let text = templateItemInfo(res.name[0],res.series[0],res.type[0],res.place[0]);
        console.log(text)
        document.getElementById("display").innerHTML=text;
      })
}
///
///test
///
console.log(dataUser);
document.getElementById("username").innerHTML = dataUser.username;
