//From Arduino to Processing to Txt or cvs etc.
//import
import processing.serial.*;
//declare
PrintWriter output;
Serial udSerial;
Serial udSerial2;

void setup() {
  udSerial = new Serial(this, Serial.list()[0], 9600);
  //udSerial2 = new Serial(this, Serial.list()[1], 9600);
}

  void draw() {
    if (udSerial.available() > 0) {
      String senVal = udSerial.readStringUntil('\n');
      if (senVal != null) {
        output = createWriter ("C:\\xampp\\htdocs\\attendance-monitoring-system\\rfid_data.json");
        output.println("{\"id\" : \"" + trim(senVal) + "\"}");
        println("{\"id\" : \"" + trim(senVal) + "\"}");
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
