#include <Wire.h>
#include <LiquidCrystal_I2C.h>


const int TRIG_PIN_1 = 2;
const int ECHO_PIN_1 = 3;
const int TRIG_PIN_2 = 4;
const int ECHO_PIN_2 = 5;
const int BUZZER_PIN = 8;

class GuestCounter {
public:
  int guestCount;
  int buzzerActive;

  LiquidCrystal_I2C lcd{0x27, 16, 2};

  GuestCounter() : guestCount(0), buzzerActive(false) {}


//Initialize the guest counter setup, including sensors, LCD, and buzzer.
  

  void SETUP() {
    Serial.begin(9600);

    // Initialize LCD
    lcd.init();
    //lcd.begin(16, 2);
    lcd.backlight();
    pinMode(TRIG_PIN_1, OUTPUT);
    pinMode(ECHO_PIN_1, INPUT);
    pinMode(TRIG_PIN_2, OUTPUT);
    pinMode(ECHO_PIN_2, INPUT);
    pinMode(BUZZER_PIN, OUTPUT);
  }


 //Main loop for the guest counter functionality.
  
  void LOOP() {
    int distance1 = getDistance(TRIG_PIN_1, ECHO_PIN_1);
    int distance2 = getDistance(TRIG_PIN_2, ECHO_PIN_2);
    bool d1, d2;

  
    if (distance1 <= 8 ) {
      delay(700);
    
      if(distance2 <= 8 && distance1) {
        delay(800);
      handleGuestEntering();
      }

      else if(distance1 <= 8){
        delay(800);
        Serial.println(" ");
      }

    }

    if (distance2 <= 8) {
      delay(700);

       if(distance1 <= 8) {
      handleGuestEntering();
      }

      else if(distance2 <= 8){
        Serial.println(" ");
      }
    }

    if (guestCount >= 20 ) {
      handleGuestLimitReached();
    }
   
  }

  
  // Handle a guest entering the room.
   
  void handleGuestEntering() {
    //delay(800); // Wait for 2 second to avoid counting the same person multiple times
    guestCount++;
    updateDisplay("Guest Entering", guestCount);
    Serial.print("Guest Entering. Count: ");
    Serial.println(guestCount);
  }

  /*
   * Handle a guest exiting the room.
   */
  void handleGuestExiting() {
    if(guestCount > 0){
     // delay(800); // Wait for 2 second to avoid counting the same person multiple times
      guestCount--;
      updateDisplay("Guest Exiting", guestCount);
      Serial.print("Guest Exiting. Count: ");
      Serial.println(guestCount);
    }
    if (guestCount <= 20) {
      
      // If guest count drops below 20, reset buzzer state
      digitalWrite(BUZZER_PIN, LOW);
    }
    
  }


  //Handle the guest count reaching the limit.
   
  void handleGuestLimitReached() {
    digitalWrite(BUZZER_PIN, HIGH);
  
    updateDisplay("Guest Limit Reached", guestCount);
    Serial.println("Guest Limit Reached. Buzzer active.");
  }

  
  //Update the LCD display with the given message and count.
   
  void updateDisplay(const char *message, int count) {
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print(message);
    lcd.setCursor(0, 1);
    lcd.print("Count: ");
    lcd.print(count);
  }

  
   //Get the distance from the ultrasonic sensor connected to the given pins.
   

  int getDistance(int trigPin, int echoPin) {
    // Function to get the distance from the ultrasonic sensor
    digitalWrite(trigPin, LOW);
    delayMicroseconds(2);
    digitalWrite(trigPin, HIGH);
    delayMicroseconds(10);
    digitalWrite(trigPin, LOW);

    return pulseIn(echoPin, HIGH) * 0.034 / 2;
  }
};

GuestCounter guestCounter;

void setup() {
  guestCounter.SETUP();
}

void loop() {
  guestCounter.LOOP();
}