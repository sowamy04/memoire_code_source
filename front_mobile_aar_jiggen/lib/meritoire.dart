/* import 'package:contact_picker/contact_picker.dart';
import 'package:flutter/material.dart';

class MeritoireFragment extends StatefulWidget {
  @override
  _MeritoireFragmentState createState() => _MeritoireFragmentState();
}

class _MeritoireFragmentState extends State<MeritoireFragment> {
  String? number, name, phone;
  final ContactPicker contactPicker = new ContactPicker();

  @override
  initState() {
    super.initState();
    number = "";
    name = "";

    //open contact picker
    //Contact contact = await contactPicker.selectContact();

    //get phone number with label
    //phone = contact.phoneNumber.toString();

    //get phone number only
    //number = contact.phoneNumber.number;

    //get name only
    //name = contact.fullName;
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      home: Scaffold(
      body: Container(
        padding: EdgeInsets.all(20),
        color: Colors.purple.shade50,
        child: Column(
          children: [
            Text("Numéro de téléphone: $number"),
            Text("Nom complet: $name"),
            Divider(),
            Container(
              child: ElevatedButton(
                onPressed: () async {
                  Contact contact = await contactPicker.selectContact();
                  number = contact.phoneNumber.number;
                  name = contact.fullName;
                  setState(() {});
                },
                child: Text("Choisir un contact"),
              ),
              padding: EdgeInsets.all(20),
            ),
          ],
        ),
      ),
    ));
  }
}
 */