package com.jesuslagares.habittracker.ui.auth

import android.content.Context
import android.content.Intent
import android.os.Bundle
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.ContentProviderCompat.requireContext
import com.google.firebase.auth.FirebaseAuth
import com.jesuslagares.habittracker.R
import com.jesuslagares.habittracker.ui.MainActivity
import com.jesuslagares.habittracker.ui.fragments.habitlist.HabitList
import kotlinx.android.synthetic.main.activity_auth.*

class AuthActivity:  AppCompatActivity()
{

    override fun onCreate(savedInstanceState: Bundle?)
    {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_auth)

        setup()
        session()

    }

    private fun session()
    {

        val prefs = getSharedPreferences("myPrefs", Context.MODE_PRIVATE)
        val email = prefs.getString("email", null)

        if (email != null)
        {

            val habitListIntent = Intent(this, MainActivity::class.java).apply {

                putExtra("email" , email)

            }
            startActivity(habitListIntent)
            finish()


        }
    }

    private fun setup()
    {

        title = "Authentication"

        btn_register.setOnClickListener {

            // If the fields are not empty
            if (et_email.text.isNotEmpty() && et_password.text.isNotEmpty())
            {

                FirebaseAuth.getInstance().createUserWithEmailAndPassword(et_email.text.toString(), et_password.text.toString()).addOnCompleteListener {

                    if (it.isSuccessful)
                    {

                        val habitListIntent = Intent(this, MainActivity::class.java).apply {

                            putExtra("email" , it.result?.user?.email ?: "")

                        }
                        startActivity(habitListIntent)
                        finish()

                    }

                    else
                    {

                        Toast.makeText(this, "Register Failed", Toast.LENGTH_SHORT).show()

                    }

                }

            }

            else
            {

                Toast.makeText(this, "Please fill all the fields", Toast.LENGTH_SHORT).show()


            }

        }

        btn_login.setOnClickListener {

            // If the fields are not empty
            if (et_email.text.isNotEmpty() && et_password.text.isNotEmpty())
            {

                FirebaseAuth.getInstance().signInWithEmailAndPassword(et_email.text.toString(), et_password.text.toString()).addOnCompleteListener {

                    if (it.isSuccessful)
                    {

                        val habitListIntent = Intent(this, MainActivity::class.java).apply {

                            putExtra("email" , it.result?.user?.email?: "")

                        }
                        startActivity(habitListIntent)
                        finish()


                    }

                    else
                    {

                        Toast.makeText(this, "Login Failed", Toast.LENGTH_SHORT).show()

                    }

                }

            }

            else
            {

                Toast.makeText(this, "Please fill all the fields", Toast.LENGTH_SHORT).show()


            }

        }

    }

}