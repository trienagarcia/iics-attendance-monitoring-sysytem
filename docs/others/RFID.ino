#include <MFRC522.h>
#include <SPI.h>

int RST_PIN = 9;
int SS_PIN = 10;

MFRC522 mfrc522(SS_PIN, RST_PIN);
MFRC522::MIFARE_Key key;

const int maximum = 5;
byte RFID_CARDID[maximum] = {202,235,239,210,115};
String RFID_USER[maximum] = {"WHITE","BLUE","JULI","JAR","IGNA"};

void setup()
{
  Serial.begin(9600);

  SPI.begin();
  mfrc522.PCD_Init();
}

void loop()
{

//  Serial.println("Hello world");
  
  if(!mfrc522.PICC_IsNewCardPresent())
    return;

  if(!mfrc522.PICC_ReadCardSerial())
    return;
      
  dump(mfrc522.uid.uidByte, mfrc522.uid.size);

  delay(1000);
}

void dump(byte *buffer, byte bufferSize)
{
  byte total = 0;
  
  //print UID
//  Serial.print("Card UID: ");
  
  for(byte i = 0; i < bufferSize; i++)
    Serial.print(buffer[i], HEX);
    
  Serial.println();

  //print USERNAME
//  Serial.print("Username: ");
//  
//  for(byte i = 0; i < bufferSize; i++)
//    total += buffer[i];
//
//  for(int i = 0; i < maximum; i++)
//    if(total == RFID_CARDID[i])
//      Serial.println(RFID_USER[i]);
//
//  Serial.println();  
}

// white A7 C1 10 52  
// blue  C6 79 B4 F8 
