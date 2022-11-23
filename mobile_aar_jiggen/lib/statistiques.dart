import 'package:flutter/material.dart';

class StatistiquesFragment extends StatefulWidget {
  @override
  _StatistiquesFragmentState createState() => _StatistiquesFragmentState();
}

class _StatistiquesFragmentState extends State<StatistiquesFragment> {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
          body: Center(
              child: Column(children: <Widget>[
        Container(
          margin: EdgeInsets.all(25),
          child: Text(
            "Statistiques des quartiers",
            style: TextStyle(fontSize: 20),
          ),
        ),
        Container(
          margin: EdgeInsets.all(20),
          child: Table(
            defaultColumnWidth: FixedColumnWidth(120.0),
            border: TableBorder.all(
                color: Colors.black, style: BorderStyle.solid, width: 2),
            children: [
              TableRow(children: [
                Column(children: [Text('#', style: TextStyle(fontSize: 10.0))]),
                Column(children: [
                  Text('Quartier', style: TextStyle(fontSize: 10.0))
                ]),
                Column(children: [
                  Text('Note /5', style: TextStyle(fontSize: 10.0))
                ]),
              ]),
              TableRow(children: [
                Column(children: [Text('1')]),
                Column(children: [Text('Mermoz-Sacré-coeur')]),
                Column(children: [Text('1.55')]),
              ]),
              TableRow(children: [
                Column(children: [Text('2')]),
                Column(children: [Text('Grand Yoff')]),
                Column(children: [Text('2.12')]),
              ]),
              TableRow(children: [
                Column(children: [Text('3')]),
                Column(children: [Text('Almadies')]),
                Column(children: [Text('4')]),
              ]),
            ],
          ),
        ),
      ]))),
    );
  }
}
