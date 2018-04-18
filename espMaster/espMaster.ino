#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMesh.h>

const char* ssid = "Fab";
const char* password = "suggestions";
String url = "http://192.168.43.137/symfony4_admin_wemos/public/index.php/data";

String manageRequest(String request);

/* Create the mesh node object */
ESP8266WiFiMesh mesh_node = ESP8266WiFiMesh(ESP.getChipId(), manageRequest);

/**
 * Callback for when other nodes send you data
 *
 * @request The string received from another node in the mesh
 * @returns The string to send back to the other node
 */
String manageRequest(String request)
{
  /* Print out received message 
  Serial.print("received: ");
  Serial.println(request);*/

  String formattedData = request;

  //formattedData.replace(".", "%2E");

  // send data to cloud
  postData(formattedData);

  /* return a string to send back */
  char response[60];
  sprintf(response, "#ACK#MASTER#");
  return response;
}

void setup() {
 
  Serial.begin(115200);    //Serial connection
  
  WiFi.begin(ssid, password);   //WiFi connection
 
  while (WiFi.status() != WL_CONNECTED) {  //Wait for the WiFI connection completion
    delay(500);
    Serial.println("Waiting for connection");
  }

  Serial.println("Setting up mesh node...");
  delay(10);
  /* Initialise the mesh node */
  mesh_node.begin();
  
}
 
void loop() {

  /* Accept any incoming connections */
  mesh_node.acceptRequest();
 
  delay(500);
}

void postData(String data){
  
  if(WiFi.status()== WL_CONNECTED){   //Check WiFi connection status
    
   HTTPClient http;    //Declare object of class HTTPClient

   String urlData = url+data;
   Serial.println("Sending data to cloud : "+urlData);

   http.begin(urlData);      //Specify request destination
   http.addHeader("Content-Type", "text/plain");  //Specify content-type header
 
   int httpCode = http.GET();   //Send the request
   String payload = http.getString(); //Get the response payload
 
   Serial.println("Http response : "+httpCode);   //Print HTTP return code
   Serial.println("Http payload : "+payload);    //Print request response payload
 
   http.end();  //Close connection
   
 }else{
    Serial.println("Error in WiFi connection");   
 }
}

