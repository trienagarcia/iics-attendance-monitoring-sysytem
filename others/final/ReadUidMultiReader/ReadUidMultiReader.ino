#include <SPI.h>
#include <MFRC522.h>

#define RST_PIN         9          
#define SS_1_PIN        10         
#define SS_2_PIN        4          

#define NR_OF_READERS   2
const int LED1 = 5;
byte ssPins[] = {SS_1_PIN, SS_2_PIN};

MFRC522 mfrc522[NR_OF_READERS];   

void setup() {

  Serial.begin(9600); 
  while (!Serial);    

  SPI.begin();        
  pinMode(LED1, OUTPUT);
  digitalWrite(LED1,LOW);

//  Serial.println("Setup...");
  for (uint8_t reader = 0; reader < NR_OF_READERS; reader++) {
    mfrc522[reader].PCD_Init(ssPins[reader], RST_PIN); 
//    Serial.print(F("Reader "));
//    Serial.print(reader);
//    Serial.print(F(": "));
//    mfrc522[reader].PCD_DumpVersionToSerial();
//    Serial.print("MFRC522 software version = ");
//    Serial.println(mfrc522[reader].PCD_ReadRegister(mfrc522[reader].VersionReg),HEX);
  }
}


void loop() {

  for (uint8_t reader = 0; reader < NR_OF_READERS; reader++) {
    

    if (mfrc522[reader].PICC_IsNewCardPresent() && mfrc522[reader].PICC_ReadCardSerial()) {
      
//      Serial.print(F("Reader "));
//      Serial.print(reader);
      
//      Serial.print(F(": Card UID:"));
      dump_byte_array(mfrc522[reader].uid.uidByte, mfrc522[reader].uid.size);
          

      digitalWrite(LED1,HIGH);
      delay(400);
      digitalWrite(LED1,LOW);
      
      mfrc522[reader].PICC_HaltA();
      mfrc522[reader].PCD_StopCrypto1();
    } 
  } 
}


void dump_byte_array(byte *buffer, byte bufferSize) {
  for (byte i = 0; i < bufferSize; i++) {
//    Serial.print(buffer[i] < 0x10 ? " 0" : " ");
    Serial.print(buffer[i], HEX);
  }

  Serial.println(); 
}
