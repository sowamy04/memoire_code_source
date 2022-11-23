import 'dart:typed_data';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_contacts/flutter_contacts.dart';
import 'package:mobile_aar_jiggen/tracker.dart';
import 'package:url_launcher/url_launcher.dart';
import 'services/interceptor.dart';
import 'package:hooks_riverpod/hooks_riverpod.dart';
import 'api/call_api.dart';

class MeritoireFragment extends StatefulWidget {
  const MeritoireFragment({Key? key}) : super(key: key);

  @override
  _MeritoireFragmentState createState() => _MeritoireFragmentState();
}

class _MeritoireFragmentState extends State<MeritoireFragment> {
  final apiProvider = Provider((ref) => Api());
  List<Contact>? contacts;
  final String _message = "Personne de confiance ajoutée avec succès pour le suivi de votre déplacement";
  @override
  void initState() {
    // TODO: implement initState
    super.initState();
    getContact();
  }

  void getContact() async {
    if (await FlutterContacts.requestPermission()) {
      contacts = await FlutterContacts.getContacts(
          withProperties: true, withPhoto: true);
      print(contacts);
      setState(() {});
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        /* appBar: AppBar(
          title: const Text(
            "***  App Name  ***",
            style: TextStyle(color: Colors.blue),
          ),
          centerTitle: true,
          backgroundColor: Colors.transparent,
          elevation: 0,
        ), */
        body: (contacts) == null
            ? Center(child: CircularProgressIndicator())
            : ListView.builder(
                itemCount: contacts!.length,
                itemBuilder: (BuildContext context, int index) {
                  Uint8List? image = contacts![index].photo;
                  String num = (contacts![index].phones.isNotEmpty)
                      ? (contacts![index].phones.first.number)
                      : "--";
                  return ListTile(
                      leading: (contacts![index].photo == null)
                          ? const CircleAvatar(child: Icon(Icons.person))
                          : CircleAvatar(backgroundImage: MemoryImage(image!)),
                      title: Text(
                          "${contacts![index].name.first} ${contacts![index].name.last}"),
                      subtitle: Text(num),
                      onTap: () {
                        if (contacts![index].phones.isNotEmpty) {
                          chooseMeritoire(
                              "${contacts![index].name.first} ${contacts![index].name.last}",
                              "${contacts![index].phones}");
                          final snackBar = SnackBar(
                            content: Text(_message),
                            action: SnackBarAction(
                              label: 'OK',
                              onPressed: () {
                                /* Navigator.of(context).pushAndRemoveUntil(
                                    MaterialPageRoute(
                                        builder: (context) =>
                                            TrackerFragment()),
                                    (Route<dynamic> route) => false);*/
                              },
                            ),
                          );
                          ScaffoldMessenger.of(context).showSnackBar(snackBar);
                          /* Navigator.of(context).pushAndRemoveUntil(
                              MaterialPageRoute(
                                  builder: (context) => TrackerFragment()),
                              (Route<dynamic> route) => false);*/
                        } 
                      });
                },
              ));
  }
}





/* import 'package:fast_contacts/fast_contacts.dart';
import 'package:flutter/material.dart';
import 'package:permission_handler/permission_handler.dart';

class MeritoireFragment extends StatefulWidget {
  @override
  _MeritoireFragmentState createState() => _MeritoireFragmentState();
}

class _MeritoireFragmentState extends State<MeritoireFragment> {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      //debugShowCheckedModeBanner: false,
      theme: ThemeData(
        primarySwatch: Colors.green,
      ),
      home: Scaffold(
        body: Container(
          height: double.infinity,
          child: FutureBuilder(
            future: getContacts(),
            builder: (context, AsyncSnapshot snapshot) {
              if (snapshot.data == null) {
                return const Center(
                  child:
                      SizedBox(height: 50, child: CircularProgressIndicator()),
                );
              }
              return ListView.builder(
                  itemCount: snapshot.data.length,
                  itemBuilder: (context, index) {
                    Contact contact =
                        snapshot.data[index] ? snapshot.data[index] : '';
                    return Column(children: [
                      ListTile(
                        leading: const CircleAvatar(
                          radius: 20,
                          child: Icon(Icons.person),
                        ),
                        title: Text(contact.displayName),
                        subtitle: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(contact.phones[0]),
                            //Text(contact.emails[0]),
                          ],
                        ),
                      ),
                      const Divider()
                    ]);
                  });
            },
          ),
        ),
      ),
    );
  }

  Future<List<Contact>> getContacts() async {
    bool isGranted = await Permission.contacts.status.isGranted;
    if (!isGranted) {
      isGranted = await Permission.contacts.request().isGranted;
    }
    if (isGranted) {
      return await FastContacts.allContacts;
    }
    return [];
  }
}

 */

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
} */