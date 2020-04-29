//From Arduino to Processing to Txt or cvs etc.
//import
import processing.serial.*;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import org.apache.hc.client5.http.classic.methods.HttpPost;
import org.apache.hc.client5.http.entity.UrlEncodedFormEntity;
import org.apache.hc.client5.http.impl.classic.CloseableHttpClient;
import org.apache.hc.client5.http.impl.classic.CloseableHttpResponse;
import org.apache.hc.client5.http.impl.classic.HttpClients;
import org.apache.hc.core5.http.NameValuePair;
import org.apache.hc.core5.http.ParseException;
import org.apache.hc.core5.http.io.entity.EntityUtils;
import org.apache.hc.core5.http.message.BasicNameValuePair;
//declare


PrintWriter output;
Serial udSerial;
Serial udSerial2;
String timestamp;
String url;

void setup() {
     url = "https://iics-attendance-monitoring.000webhostapp.com/rfid_http_test";
     udSerial = new Serial(this, Serial.list()[1], 9600);
}


void draw() {
  
  if (udSerial.available() > 0) {
      String rfidData = udSerial.readStringUntil('\n');
      if (rfidData != null) {
        println("{\"id\" : \"" + trim(rfidData) + "\", \"timestamp\" : \"" + timestamp + "\"}");
        try{
          String result = sendPOST(url, rfidData);
          System.out.println(result);
        } catch (IOException e) {
          e.printStackTrace();
        }  
      }
    }
}


private String sendPOST(String url, String rfidData) throws IOException {
          String timestamp = year() + "-" + month() + "-" + day() + " " + hour() + ":" + minute() + ":" + second();
          String result = "";
          HttpPost post = new HttpPost(url);

          // add request parameters or form parameters
          List<NameValuePair> urlParameters = new ArrayList<NameValuePair>();
          urlParameters.add(new BasicNameValuePair("rfid_name", rfidData));
          urlParameters.add(new BasicNameValuePair("datetime", timestamp));
//          post.addHeader("content-type", "application/x-www-form-urlencoded");
//          post.addHeader("Content-Length", "email");
//          post.addHeader("X-THINGSPEAKAPIKEY", writeApiKey);
          post.setEntity(new UrlEncodedFormEntity(urlParameters));

          try{
            CloseableHttpClient httpClient = HttpClients.createDefault();
            CloseableHttpResponse response = httpClient.execute(post);

              result = EntityUtils.toString(response.getEntity());
              System.out.println("result: " + result);
          } catch (ParseException e) {
              e.printStackTrace();
          }  

          return result;
}
