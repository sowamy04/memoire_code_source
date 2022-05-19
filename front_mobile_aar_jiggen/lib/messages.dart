import 'package:flutter/material.dart';
import 'package:flutter_sms/flutter_sms.dart';

class MessageFragment extends StatefulWidget {
  @override
  _MessageFragmentState createState() => _MessageFragmentState();
}

class _MessageFragmentState extends State<MessageFragment> {
  String message = "Tu ne suis plus la voix normal est-ce que tout vas bien?";
  List<String> recipents = ["774221315"];

  void _sendSMS(String message, List<String> recipents) async {
    String _result = await sendSMS(message: message, recipients: recipents)
        .catchError((onError) {
      print(onError);
    });
    print(_result);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        child: Center(
          child: Padding(
            padding: const EdgeInsets.all(8.0),
            child: RaisedButton(
              color: Colors.blue,
              padding: EdgeInsets.symmetric(vertical: 16),
              child: Text(
                "Envoyer un message",
              ),
              onPressed: () {
                _sendSMS(message, recipents);
              },
            ),
          ),
        ),
      ),
    );
  }
}
