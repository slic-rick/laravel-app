import DOMPurify from "dompurify"

export default class Profile {
  constructor() {
    
    this.links = document.querySelectorAll(".profile-nav a")
    this.contentArea = document.querySelector(".profile-slot-content")
    this.events()
    this.getInitData();

  }

  async getInitData(){
    const response = await axios.get("web-dev/raw")
    // console.log(response.data.theHTML);
    this.contentArea.innerHTML = DOMPurify.sanitize(response.data.theHTML)
  }

  // events
  events() {
    addEventListener("popstate", () => {
      this.handleChange()
    })
    this.links.forEach(link => {
      link.addEventListener("click", e => this.handleLinkClick(e))
    })
  }

  handleChange() {
    this.links.forEach(link => link.classList.remove("active"))
    this.links.forEach(async link => {
      if (link.getAttribute("href") == window.location.pathname) {
        // console.log(typeof(link.href));
        // alert(link.href)
        // if(link.href === "http://127.0.0.1:8000/"){
          const response = await axios.get(link.href + "/raw")
        // }else{
        //   const response = await axios.get(link.href + "/raw")
        // }
        

       this.contentArea.innerHTML = DOMPurify.sanitize(response.data.theHTML)
        document.title = response.data.pageName + " | OurApp"
        link.classList.add("active")
      }
    })
  }

  // methods
  async handleLinkClick(e) {
    this.links.forEach(link => link.classList.remove("active"))
    e.target.classList.add("active")
    e.preventDefault()
    // console.log(typeof(e.target.href));
    // alert(e.target.href)
    // if(e.target.href === "http://127.0.0.1:8000/"){
      const response = await axios.get(e.target.href + "/raw");
    // }else{
    //   const response = await axios.get(e.target.href + "/raw")
    // }
    this.contentArea.innerHTML = DOMPurify.sanitize(response.data.theHTML)
    document.title = response.data.pageName + " | OurApp"

    history.pushState({}, "", e.target.href)
  }
}