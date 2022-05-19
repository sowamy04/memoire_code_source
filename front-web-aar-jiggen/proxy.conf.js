module.exports[
  {
    context : ['/api/*'],
    target : "http://localhost:8000",
    secure : false,
    logLevel : "debug",
    bypass : function(req, res, proxyOptions){
      res.setHeader("Access-Control-Allow-Origin" , "http://localhost:8000")
    }
  }
]
