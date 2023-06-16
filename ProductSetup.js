import React, {useState,useEffect} from 'react';
import { Link ,Outlet} from 'react-router-dom';
import Axios from 'axios';
import Logout from '../../Logout';



const ProductSetup = (props)=>{




 const [productData,setProductData] = useState({category:'',product_title: '' })






const [data,updateDate] = useState([]);
const [datastate,updateDataState] = useState(0);





const getProduct_data = async () => {
  try {
      const resp = await Axios.post("http://localhost/api/Product_conf/get_product_api.php", {'company_id':localStorage.getItem('company_id'),'session_user_id':localStorage.getItem('session_user_id'),  'db':localStorage.getItem('db')});
      updateDate(resp.data);

      console.log(resp.data);
  } catch (err) {
      // Handle Error Here
      console.error(err);
  }
};






useEffect(()=>{

  getProduct_data();

},[datastate]);





const handleChange = (e)=>{

setProductData((prev)=>{
 
             return {...prev,[e.target.name]:e.target.value,'company_id':localStorage.getItem('company_id'),'session_user_id':localStorage.getItem('session_user_id'),  'db':localStorage.getItem('db')}
    })

}



const handleSubmit = (e)=>{

     e.preventDefault();

     Axios.post("http://localhost/api/Product_conf/product_setup_api.php",productData).then((response)=>{


      localStorage.setItem('product_status',response.data.product_status); 

          }).catch((error)=>{ })

       setProductData({
        category:'',
        product_title: ''
     
    })



updateDataState(datastate+1);

}

console.log(data);


  return(
        <>
            
            <div className="content-header">
     <div className="container-fluid">
      <div className="row mb-2">
         <div className="col-sm-6">
           <h1 className="m-0">{props.config_title.title}</h1>
         <hr/>
         </div>
         <div className="col-sm-6">
           <ol className="breadcrumb float-sm-right">
            <li className="breadcrumb-item active"><h3>{props.config_title.process}</h3></li>
         <Logout/>
            
           </ol>
         </div>
      </div>
     </div>
    </div>
    
    
    
    <section className="content">
      <div className="container-fluid">
        <div className="row">
    
 <div className="col-md-4">fff</div>
       
      
      <div className="col-md-7">
                <div className="card card-primary">
              <div className="card-header">
                <h3 className="card-title">Add Product</h3>
              </div>
            
              <form onSubmit={handleSubmit}>
                              <div className="card-body">
                 <div className="row"> 

                  
                 <div className="col-md-6">
                    <p style={{'font-size':'10px'}}> *Please checked one category to add product inside the category </p>
                    
                     
                   <div className="form-group">
                   
                                        <label class="radio-inline">
                                            <input type="radio" name="category" value="1" onChange={handleChange}/>
                                            Product
                                        </label>
                                          &nbsp;  &nbsp;  &nbsp;
                                        <label class="radio-inline">
                                            <input type="radio" name="category" value="2" onChange={handleChange}/>
                                            Custom Product
                                        </label>
                                          &nbsp;  &nbsp;  &nbsp;
                                        <label class="radio-inline">
                                            <input type="radio" name="category" value="3" onChange={handleChange}/>
                                            Material
                                        </label>         
                  </div>

                  <div className="form-group">
                    <label>Product Title</label>
                    <input type="text" name="product_title" className="form-control"  value={productData.product_title} onChange={handleChange} placeholder="Enter Country"/>
                  </div>
                       
           <div className="form-group">
                     <button type="submit" className="btn btn-warning" >Submit</button>
                  </div>



                  </div>
                  <div className="col-md-6">
                    <h3>Product List</h3>

                    {data? Object.keys(data).map((cate_data, index) => {
                          
                         return(<>
                                <h5 key={index}><br/>{cate_data}</h5><hr/>
                                     <table className="table">
                                        <thead>
                                           <tr>
                                              <th>S.No.</th>
                                              <th>Title</th>
                                              <th></th>
                                           </tr>
                                        </thead>
                                        <tbody>

                                  {data[cate_data]? data[cate_data].map((product,i)=>{

                                             return(<tr key={i}>
                                                        <td>{product.id}</td>
                                                        <td>{product.product_title}</td>
                                                        <td><Link to="MaterialConfig"><button className='btn btn-success btn-xs'>Material Config</button></Link></td>
                                                     </tr>)
                                    }) : "There are no Products Available"
                                  }
                                       </tbody>
                                       </table>

                               </>)

                       }) : "Empty Category"}
                   
                  </div>


               
                 </div>  
                     <div className="card-footer">

                   <Link to="/BranchSetup"><button type="button" className="btn btn-primary" style={{float:'left'}} >Back</button></Link>
                   <Link to="/OrderTypeSetup"><button type="button" className="btn btn-primary" style={{float:'right'}}  >Next</button></Link>
                </div>
                    
      
               
              
            </div>
</form>
            </div>
            
 

        </div>

      
      </div>

      <div className="row">
      <Outlet/>
      </div>


      </div> 
    </section>  
      
   
         </>


  );


}
export default ProductSetup;
