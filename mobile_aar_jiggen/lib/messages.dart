/* import 'package:flutter/material.dart';
import 'package:telephony/telephony.dart';

class MessageFragment extends StatefulWidget {
  const MessageFragment({Key? key, required this.title}) : super(key: key);
  final String title;
  @override
  _MessageFragmentState createState() => _MessageFragmentState();
}
  


class _MessageFragmentState extends State<MessageFragment>{
  final Telephony telephony = Telephony.instance;

  final _formKey = GlobalKey<FormState>();
  final TextEditingController _phoneController = TextEditingController();
  final TextEditingController _msgController = TextEditingController();
  final TextEditingController _valueSms = TextEditingController();

  @override
  void initState() {
    super.initState();
    _phoneController.text = '55555';
    _msgController.text = 'Message :)';
    _valueSms.text = '10';
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(widget.title),
      ),
      body: Padding(
        padding: EdgeInsets.all(8.0),
        child: Form(
          key: _formKey,
          child: SingleChildScrollView(
            child: Column(
              children: [
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _phoneController,
                    keyboardType: TextInputType.phone,
                    validator: (value) {
                      if (value == null || value.isEmpty) {
                        return 'Numéro de téléphone invalide';
                      }
                      return null;
                    },
                    decoration: const InputDecoration(
                        border: OutlineInputBorder(),
                        hintText: 'HOME P',
                        labelText: 'HOMEP'),
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _msgController,
                    validator: (value) {
                      if (value == null || value.isEmpty) {
                        return 'message';
                      }
                    },
                    decoration: const InputDecoration(
                      border: OutlineInputBorder(),
                      hintText: 'Décoration',
                      labelText: 'Déco',
                    ),
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: TextFormField(
                    controller: _valueSms,
                    keyboardType: TextInputType.number,
                    validator: (value) {
                      if (value == null || value.isEmpty) {
                        return 'value sms invalid';
                      }
                    },
                    decoration: const InputDecoration(
                      border: OutlineInputBorder(),
                      hintText: 'Text',
                      labelText: 'TextLabel',
                    ),
                  ),
                ),
                ElevatedButton(
                    onPressed: () => _sendSMS(), child: const Text('Message')),
                ElevatedButton(
                    onPressed: () => _getSMS(),
                    child: const Text('Le message')),
              ],
            ),
          ),
        ),
      ),
    );
  }

  _sendSMS() async {
    int _sms = 0;
    while (_sms < int.parse(_valueSms.text)) {
      telephony.sendSms(
          to: _phoneController.text, message: _msgController.text);
      _sms++;
    }
  }

  _getSMS() async {
    List<SmsMessage> _messages = await telephony.getInboxSms(
        columns: [SmsColumn.ADDRESS, SmsColumn.BODY],
        filter:
            SmsFilter.where(SmsColumn.ADDRESS).equals(_phoneController.text));

    for (var msg in _messages) {
      print(msg.body);
    }
  }
} */

/* import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';

_sendingSMS() async {
  var url = Uri.parse("sms:00221774887764");
  if (await canLaunchUrl(url)) {
    await launchUrl(url);
  } else {
    throw 'Could not launch $url';
  }
}

class MessageFragment extends StatelessWidget {
  const MessageFragment({Key? key}) : super(key: key);
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        body: SafeArea(
          child: Center(
            child: Column(
              children: [
                Container(
                  height: 20.0,
                ),
                const Text(
                  'Envoyer un message SMS',
                  style: TextStyle(
                    fontSize: 18.0,
                    color: Color.fromARGB(255, 5, 27, 226),
                    //fontWeight: FontWeight.bold,
                  ),
                ),
                Container(
                  height: 10.0,
                ),
                ElevatedButton(
                  onPressed: _sendingSMS,
                  style: ButtonStyle(
                    padding:
                        MaterialStateProperty.all(const EdgeInsets.all(5.0)),
                    textStyle: MaterialStateProperty.all(
                      const TextStyle(color: Colors.black),
                    ),
                  ),
                  child: const Text('ICI'),
                ), // ElevatedButton
              ],
            ),
          ),
        ),
      ),
    );
  }
} */

import 'package:flutter/material.dart';
import 'package:flutter_sms/flutter_sms.dart';

class MessageFragment extends StatefulWidget {
  @override
  _MessageFragmentState createState() => _MessageFragmentState();
}

class _MessageFragmentState extends State<MessageFragment> {
  String _message = "Tu ne suis plus la voix normal est-ce que tout vas bien?";
  List<String> recipents = ["774221315"];
  TextEditingController _controllerPeople = TextEditingController();
  TextEditingController _controllerMessage = TextEditingController();
  String body = "";

  @override
  void initState() {
  super.initState();
  initPlatformState();
  }

  Future<void> initPlatformState() async {
  _controllerPeople = TextEditingController();
  _controllerMessage = TextEditingController();
  }

  void _sendSMS(String message, List<String> recipents) async {
    String result = await sendSMS(message: message, recipients: recipents)
        .catchError((onError) {
      print(onError);
    });
    print(result);
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
                _sendSMS(_message, recipents);
              },
            ),
          ),
        ),
      ),
    );
  }
}