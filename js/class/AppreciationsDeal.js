class AppreciationsDeal{
    
    constructor(appreciationArray) {
    this.appreciationArray = appreciationArray;
  }
  
  rand(){
  	let i = Math.floor(Math.random() * (this.appreciationArray.length));
  	return this.appreciationArray[i]
  }
    
}

export default AppreciationsDeal;