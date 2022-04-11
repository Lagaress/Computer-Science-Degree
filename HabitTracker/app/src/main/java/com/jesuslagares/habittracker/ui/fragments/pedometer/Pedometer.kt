package com.jesuslagares.habittracker.ui.fragments.pedometer

import android.content.Context
import android.hardware.Sensor
import android.hardware.SensorEvent
import android.hardware.SensorEventListener
import android.hardware.SensorManager
import android.os.Bundle
import android.util.Log
import android.view.View
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.ContextCompat.getSystemService
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.LinearLayoutManager
import com.google.firebase.auth.FirebaseAuth
import com.jesuslagares.habittracker.R
import com.jesuslagares.habittracker.ui.fragments.habitlist.adapters.HabitListAdapter
import kotlinx.android.synthetic.main.fragment_habit_list.*
import kotlinx.android.synthetic.main.fragment_pedometer.*

class Pedometer : Fragment(R.layout.fragment_pedometer), SensorEventListener {

    private var sensorManager: SensorManager? = null

    private var running = false
    private var totalSteps = 0f
    private var currentSteps = 0
    private var previousTotalSteps = 0f
    private var newGoal = "/ 10000"


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        loadData()
        resetSteps()
        sensorManager = this.activity?.getSystemService(Context.SENSOR_SERVICE) as SensorManager

        btn_changeSteps.setOnClickListener {

            if ( et_changeMaximumSteps.text.isNotEmpty() )
            {

                tv_totalMax.text = "/ " + et_changeMaximumSteps.text.toString()
                newGoal = "/ " + et_changeMaximumSteps.text.toString()

            }

            else
            {

                Toast.makeText(this.context, "Fill with a number of steps", Toast.LENGTH_SHORT).show()

            }

        }

    }

    override fun onResume() {
        super.onResume()
        running = true

        val stepSensor = sensorManager?.getDefaultSensor(Sensor.TYPE_STEP_COUNTER)

        if (stepSensor == null)
        {
            Toast.makeText(this.context, "No sensor detected on this device", Toast.LENGTH_SHORT).show()
        }

        else
        {

            sensorManager?.registerListener(this, stepSensor , SensorManager.SENSOR_DELAY_UI)

        }

    }



    override fun onSensorChanged(event: SensorEvent?) {
        if (running)
        {

            totalSteps = event!!.values[0]
            currentSteps = totalSteps.toInt() - previousTotalSteps.toInt()
            tv_stepsTaken.text = currentSteps.toString()!!
            tv_totalMax.text = newGoal

            circularProgressBar.apply {
                setProgressWithAnimation(currentSteps.toFloat())
            }

        }
    }

    override fun onAccuracyChanged(p0: Sensor?, p1: Int) {

        true

    }

    private fun resetSteps()
    {

        tv_stepsTaken.setOnClickListener {

            Toast.makeText(this.context, "Long tap to reset all the steps" , Toast.LENGTH_SHORT).show()

        }

        tv_stepsTaken.setOnLongClickListener {

            previousTotalSteps = totalSteps
            tv_stepsTaken.text = 0.toString()
            saveData()

            true

        }

    }

    private fun saveData()
    {

        val sharedPreferences = this.activity?.getSharedPreferences("myPrefs" , Context.MODE_PRIVATE)
        val editor = sharedPreferences?.edit()
        editor?.putFloat("key1" , previousTotalSteps)
        editor?.apply()

    }

    private fun loadData()
    {
        val sharedPreferences = this.activity?.getSharedPreferences("myPrefs" , Context.MODE_PRIVATE)
        val savedNumber = sharedPreferences?.getFloat("key1" , 0f)
        Log.d("Pedometer" , "$savedNumber")
        previousTotalSteps = savedNumber!!


    }



}