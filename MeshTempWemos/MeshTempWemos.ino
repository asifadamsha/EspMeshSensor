#include <ESP8266WiFi.h>
#include <ESP8266WiFiMesh.h>
#include "DHT.h"

// Setting up the DHT
#define DHTPIN D4
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

float t,h;
unsigned int request_i = 0;
unsigned int response_i = 0;

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
  /* Print out received message */
  Serial.print("received: ");
  Serial.println(request);

  /* return a string to send back */
  char response[60];
  sprintf(response, "Hello world response #%d from Mesh_Node%d.", response_i++, ESP.getChipId());
  return "OK";
}

void setup()
{

  Serial.begin(115200);
  delay(10);

  Serial.println();
  Serial.println();
  Serial.println("Setting up mesh node...");

  /* Initialise the mesh node */
  mesh_node.begin();

  // Connection to the DHT sensor
  dht.begin();
}

void loop()
{
  t = dht.readTemperature();
  h = dht.readHumidity();

  //test du rendu 
  /*Serial.print("Temperature: ");
  Serial.print(t);
  Serial.println("C");

  Serial.print("Humidity: ");
  Serial.print(h);
  Serial.println("%");*/

  /* Accept any incoming connections */
  mesh_node.acceptRequest();

  /* Scan for other nodes and send them a message */
  char request[600];
  sprintf(request, "/salon/temperature/%.2f",t);
  mesh_node.attemptScan(request);
  sprintf(request, "/salon/humidity/%.2f",h);
  mesh_node.attemptScan(request);
  delay(1000);
}

