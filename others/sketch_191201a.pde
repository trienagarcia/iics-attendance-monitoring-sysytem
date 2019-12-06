//From Arduino to Processing to Txt or cvs etc.
//import
import processing.serial.*;
//declare
PrintWriter output;
Serial udSerial;
Serial udSerial2;
String timestamp;

void setup() {
  udSerial = new Serial(this, Serial.list()[0], 9600);
  //udSerial2 = new Serial(this, Serial.list()[1], 9600);
}

  void draw() {
    timestamp = year() + "-" + month() + "-" + day() + " " + hour() + ":" + minute() + ":" + second();
    if (udSerial.available() > 0) {
      String senVal = udSerial.readStringUntil('\n');
      if (senVal != null) {
        output = createWriter ("C:\\xampp\\htdocs\\attendance-monitoring-system\\rfid_data.json");
        output.println("{\"id\" : \"" + trim(senVal) + "\", \"timestamp\" : \"" + timestamp + "\"}");
        println("{\"id\" : \"" + trim(senVal) + "\", \"timestamp\" : \"" + timestamp + "\"}");
        output.flush();
        output.close();
      }
    }
  }

  //void keyPressed(){
  //  output.flush();
  //  output.close();
  //  exit();
  //}
